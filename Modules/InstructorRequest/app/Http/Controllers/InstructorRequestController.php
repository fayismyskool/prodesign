<?php

namespace Modules\InstructorRequest\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\InstructorRequest\app\Models\InstructorRequest;
use Modules\InstructorRequest\app\Services\EmailService;

class InstructorRequestController extends Controller
{
    use RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');
        $query = InstructorRequest::query();
        $query->with(['user']);
        $query->when($request->keyword, function($q) use ($request) {
            $q->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->keyword}%")
                    ->orWhere('email', 'like', "%{$request->keyword}%")
                    ->orWhere('phone', 'like', "%{$request->keyword}%");
            });
        });
        $query->when($request->status, fn ($q) => $q->where('status', $request->status));
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $instructorRequests = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        return view('instructorrequest::instructor-request.index', compact('instructorRequests'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $users = User::select('id', 'name', 'email', 'phone', 'role')
            ->orderBy('name', 'asc')
            ->get();

        $withdrawMethods = [];
        if (class_exists(\Modules\PaymentWithdraw\app\Models\WithdrawMethod::class)) {
            $withdrawMethods = \Modules\PaymentWithdraw\app\Models\WithdrawMethod::where('status', 'active')->get();
        }

        return view('instructorrequest::instructor-request.create', compact('users', 'withdrawMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $request->validate([
            'user_type' => 'required|in:existing,new',
            'user_id' => 'required_if:user_type,existing|nullable|exists:users,id',
            'name' => 'required_if:user_type,new|nullable|string|max:255',
            'email' => 'required_if:user_type,new|nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'password' => 'required_if:user_type,new|nullable|min:4',
            'status' => 'required|in:pending,approved,rejected',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,zip,doc,docx|max:10240',
            'identity_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,zip,doc,docx|max:10240',
            'payout_account' => 'nullable|string|max:255',
            'payout_information' => 'nullable|string',
            'extra_information' => 'nullable|string',
        ]);

        if ($request->user_type == 'new') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => $request->status == 'approved' ? 'instructor' : 'student',
                'status' => 'active',
                'email_verified_at' => now(),
                'phone_verified_at' => $request->phone ? now() : null,
            ]);
            $user->email_verified_at = now();
            $user->save();
            $userId = $user->id;
        } else {
            $user = User::findOrFail($request->user_id);
            if ($request->status == 'approved') {
                $user->role = 'instructor';
                $user->save();
            }
            $userId = $user->id;
        }

        $instructorRequest = InstructorRequest::updateOrCreate(
            ['user_id' => $userId],
            [
                'status' => $request->status,
                'payout_account' => $request->payout_account,
                'payout_information' => $request->payout_information,
                'extra_information' => $request->extra_information,
            ]
        );

        if ($request->hasFile('certificate')) {
            $instructorRequest->certificate = file_upload($request->file('certificate'));
            $instructorRequest->save();
        }

        if ($request->hasFile('identity_scan')) {
            $instructorRequest->identity_scan = file_upload($request->file('identity_scan'));
            $instructorRequest->save();
        }

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.instructor-request.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $instructorRequest = InstructorRequest::find($id);
        $user = User::where('id', $instructorRequest->user_id)->first();
        return view('instructorrequest::instructor-request.edit', compact('user', 'instructorRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $instructorRequest = InstructorRequest::find($id);
        $instructorRequest->status = $request->status;
        $instructorRequest->save();

        $user = User::where('id', $instructorRequest->user_id)->first();
        $user->role = 'instructor';
        $user->save();

        // (new EmailService)->handleInstructorRequestStatusMailSending([
        //     'user_email' => $instructorRequest->user->email,
        //     'user_name' => $instructorRequest->user->name,
        //     'status' => $instructorRequest->status
        // ]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.instructor-request.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $request = InstructorRequest::findOrFail($id);
        $request->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.instructor-request.index');
    }
}
