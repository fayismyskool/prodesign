<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

$dbHost = '52.66.251.181';
$dbPort = 3306;
$dbName = 'courses_dev_db';
$dbUser = 'courses_dev_user';
$dbPass = getenv('COURSES_DB_PASSWORD');

if (!$dbPass) {
    http_response_code(500);
    echo json_encode([
        'status'  => false,
        'message' => 'Database configuration is missing'
    ]);
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Request Parameters
|--------------------------------------------------------------------------
*/

$apartmentId = isset($_GET['apartment_id']) ? (int) $_GET['apartment_id'] : null;
$categoryId  = isset($_GET['category_id'])  ? (int) $_GET['category_id']  : null;

/*
|--------------------------------------------------------------------------
| Bearer Token — Authenticate User
|--------------------------------------------------------------------------
*/

$userId      = null;
$authHeader  = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$bearerToken = null;

if (preg_match('/Bearer\s+(.+)/i', $authHeader, $matches)) {
    $bearerToken = trim($matches[1]);
}

if ($bearerToken) {
    try {
        $hashedToken = hash('sha256', $bearerToken);

        $stmt = $pdo->prepare("
            SELECT tokenable_id
            FROM personal_access_tokens
            WHERE token = ?
            LIMIT 1
        ");
        $stmt->execute([$hashedToken]);
        $tokenUser = $stmt->fetch();

        if ($tokenUser) {
            $userId = (int) $tokenUser['tokenable_id'];
        }
    } catch (Exception $e) {
        error_log('Authentication error: ' . $e->getMessage());
    }
}

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

$page    = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$perPage = 50;
$offset  = ($page - 1) * $perPage;

/*
|--------------------------------------------------------------------------
| Shared Params
|--------------------------------------------------------------------------
*/

$currentDate = date('Y-m-d');

$params = [
    ':current_date' => $currentDate,
];

if ($userId) {
    $params[':user_id'] = $userId;
}

if ($apartmentId) {
    $params[':apartment_id'] = $apartmentId;
}

if ($categoryId) {
    $params[':category_id'] = $categoryId;
}

/*
|--------------------------------------------------------------------------
| Helper — Build Common FROM + JOIN + WHERE fragment
|--------------------------------------------------------------------------
*/

function buildFromWhere(bool $hasUser, ?int $apartmentId, ?int $categoryId): string
{
    $sql = "
        FROM events
        INNER JOIN locations
            ON events.location_id = locations.id
        LEFT JOIN course_apartment
            ON events.id = course_apartment.course_id
    ";

    // Exclude already-purchased events
    if ($hasUser) {
        $sql .= "
        LEFT JOIN orders AS o
            ON o.event_id = events.id
            AND o.user_id = :user_id
            AND o.status = 1
            AND o.payment_status = 1
        ";
    } else {
        $sql .= "
        LEFT JOIN orders AS o ON 1 = 0
        ";
    }

    $sql .= "
        WHERE o.id IS NULL
          AND events.end_date >= :current_date
          AND events.status = 1
          AND events.type IN (10, 8)
          AND (
              events.online = 1
              OR (
                  events.online = 0
    ";

    if ($apartmentId) {
        $sql .= "
                  AND course_apartment.apartments_id = :apartment_id
        ";
    }

    $sql .= "
              )
          )
    ";

    if ($categoryId) {
        $sql .= "
          AND events.category_id = :category_id
        ";
    }

    return $sql;
}

/*
|--------------------------------------------------------------------------
| Total Count
|--------------------------------------------------------------------------
*/

$countSql  = "SELECT COUNT(DISTINCT events.id) ";
$countSql .= buildFromWhere((bool) $userId, $apartmentId, $categoryId);

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = (int) $countStmt->fetchColumn();

/*
|--------------------------------------------------------------------------
| Fetch Courses
|--------------------------------------------------------------------------
*/

$sql  = "
    SELECT DISTINCT
        events.id,
        events.cover_image,
        events.title,
        events.location_id,
        locations.name AS location_name,
        events.price,
        events.is_featured,
        events.start_date,
        events.end_date,
        events.description,
        events.short_description,
        events.status AS course_status,
        events.slug,
        events.course_code,
        events.type,
        events.upskill,
        events.online,
        events.is_event
";
$sql .= buildFromWhere((bool) $userId, $apartmentId, $categoryId);
$sql .= " ORDER BY events.start_date ASC";
$sql .= " LIMIT :offset, :per_page";

$stmt = $pdo->prepare($sql);

// Bind named params (strings / ints via type detection)
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}

// LIMIT params must be integers
$stmt->bindValue(':offset',   $offset,  PDO::PARAM_INT);
$stmt->bindValue(':per_page', $perPage, PDO::PARAM_INT);

$stmt->execute();
$courses = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/

$totalPages = $total > 0 ? (int) ceil($total / $perPage) : 0;

echo json_encode([
    'user_id' => $userId,
    'courses' => [
        'current_page' => $page,
        'data'         => $courses,
        'from'         => $total > 0 ? $offset + 1 : null,
        'last_page'    => $totalPages,
        'per_page'     => $perPage,
        'to'           => min($offset + $perPage, $total),
        'total'        => $total,
    ],
], JSON_UNESCAPED_SLASHES);
