<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\AccountType;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UserGroupContribution;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Group::with(['manager', 'users', 'account.images'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $account = Account::make();
        $account->type()->associate(AccountType::find('2'));
        $account->save();

        try {
            $managerAccount = Account::find($data['manager_id']);
            $managerUser = User::where('account_id', $managerAccount->id)->first();
        } catch (ModelNotFoundException $e) {
            return response()
                ->json([
                    'ok' => 0,
                    'error' => $e->getMessage()
                ]);
        }

        $group = Group::make();

        $group->title = $data['title'];
        $group->manager_id = $managerAccount->id;
        $group->target_amount = $data['target_amount'];

        $group->account()
            ->associate($account)
            ->save();

        $users = [];
        if (!empty($data['members_emails']))
        {
            $emails = $data['members_emails'];
            foreach($emails as $email)
            {
                $user = User::where('email', $email)->first();
                if($user != null)
                    $users[] = $user->id;
            }
        }

        $users[] = $managerUser->id;

        try {
            $this->attachMembers($group, $users);
        } catch (Exception $e) {
            return response()
                ->json([
                    'ok' => 0,
                    'error' => $e->getMessage()
                ]);
        }

        return $group;
    }

    public function addMember(Request $request)
    {
        $response = ['ok' => 1];

        $data = $request->all();

        try {
            $user = User::find($data['user_id']);
            $group = Group::find($data['group_id']);
            $this->attachMembers($group, [$user->id]);
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function addMemberByEmail(Request $request)
    {
        $response = ['ok' => 1];

        $data = $request->all();

        try {
            $user = User::where('email', $data['email']);
            $group = Group::find($data['group_id']);
            $this->attachMembers($group, [$user->id]);
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
    
    private function attachMembers($group, array $users)
    {
        $dt = new DateTime;
        $group->users()
            ->attach($users, ['created_at' => $dt->format('Y-m-d H:i:s')]);
    }

    public function removeMember(Request $request)
    {
        $response = ['ok' => 1];

        $data = $request->all();

        try {
            $user = User::find($data['user_id']);
            $group = Group::find($data['group_id']);
            $this->detachMembers($group, [$user->id]);
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    private function detachMembers(Group $group, User $users)
    {
        $group->users()
            ->detach($users);
    }

    public function addContribution(Request $request)
    {
        $response = ['ok' => 1];

        $data = $request->all();

        try {
            $user = User::find($data['user_id']);
            $group = Group::find($data['group_id']);
            $contribution = $data['contribution'];
            $userGroupContribution = new UserGroupContribution;
            $userGroupContribution->user()
                ->associate($user);
            $userGroupContribution->group()
                ->associate($group);
            $userGroupContribution->amount = $contribution;
            $userGroupContribution->save();
            $group->updateCurrentAmount();
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $group = Group::findOrFail($id);
            $group->load(['manager', 'users', 'users.profileImages']);
            $response['group'] = $group;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    public function showByUser($userId)
    {
        $response = [
            'ok' => 1
        ];

        try {
            $user = User::findOrFail($userId);

            $groups = $user->groups;
//            $managedGroups = Group::where('manager_id', $user->account->id);
//            $groups->merge($managedGroups);

            $response['groups'] = $groups;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }
    
    public function contributions($groupId)
    {
        $response = [
            'ok' => 1
        ];
        
        try {
            $group = Group::findOrFail($groupId);
            $group->load('contributions.user');
            $group->load('contributions.user.profileImages');
            $response['contributions'] = $group->contributions;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        
        return response()
            ->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $group = Group::findOrFail($id);
            // $group->users()->detach();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'ok' => 0,
                'error' => $e->getMessage()
            ]);
        }

        $group->delete();

        return response()->json([
            'ok' => 1
        ]);
    }
}
