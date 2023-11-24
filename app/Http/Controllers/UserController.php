<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Redirect;

use App\Models\UserAccess;
use App\Models\User;

class UserController extends Controller
{

    //display faqs
    public function table(){
        $users = User::all();
        return $users;
    }
    
    public function saveAccount(Request $request)
    {
        if ($request->id) {
            $new = User::find($request->id);
        } else {
            $new = new User;
        }
        $new->name = $request->name;
        $new->email = $request->email;
        $new->role = $request->role;
        
        // Hash the password with bcrypt and specify the cost factor
        $new->password = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $res = $new->save();

        $newData = [
            'generic_pages' => $request->generic_pages,
            'faq' => $request->faq,
            'articles' => $request->articles,
            'images' => $request->images,
            'accounts' => $request->accounts
            // Add other fields as needed
        ];
    
        // Check if a record exists for the given user_id
        $res = UserAccess::updateOrInsert(
            ['user_id' => $new->id],
            $newData
        );

        return $res ? 1 : 0;
    }

    public function editUserAccess(Request $request){
        $user_id = $request->user_id;

        $newData = [
            'generic_pages' => $request->generic_pages,
            'faq' => $request->faq,
            'articles' => $request->articles,
            'images' => $request->images,
            'accounts' => $request->accounts
            // Add other fields as needed
        ];
    
        // Check if a record exists for the given user_id
        UserAccess::updateOrInsert(
            ['user_id' => $user_id],
            $newData
        );
    }


//     public function deleteAccount(Request $request){
//         $res= User::where('id', $request->id)->delete();

//         return 1;
//        //  $list = $this->table();
//        //  return $list;
//    }

   public function editForm($id){
       $user = User::find($id);
       return $user;
   } 

    public function editFormSave(Request $request)
    {
        // Validate the request data if needed

        // Find the user by ID
        $user = User::find($request->id);

        // Update the user's information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Update the password if provided
        if ($request->password) {
            $user->password = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        // Save the changes
        $user->save();

        // Update user access data
        $userAccessData = [
            'generic_pages' => $request->generic_pages,
            'faq' => $request->faq,
            'articles' => $request->articles,
            'images' => $request->images,
            'accounts' => $request->accounts,
            // Add other fields as needed
        ];

        // Check if a record exists for the given user_id
        UserAccess::updateOrInsert(
            ['user_id' => $user->id],
            $userAccessData
        );

        return response()->json(true); // Return success response
    }


    public function activateAcc($id){
        $acc = User::find($id);
        $acc->status = 1;
        $acc->save();
        return $acc;
    }

    public function deactivateAcc($id){
        $acc = User::find($id);
        $acc->status = 0;
        $acc->save();
        return $acc;
    }

    public function checkUserExists($email) {
        // Check if a user with the given email exists
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    
    public function index(Request $request)
    {
        return response()->json([
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'role' => $request->user()->role, 
        ]);
    }

    public function dashboard(){
        $role = Auth::user()->role;
        if ($role==1){
            return Inertia::reder('Dashboard', [
                'role'=> $role
            ]);
        }else if ($role == 2){
            return Inertia::reder('Dashboard', [
                'role'=> $role
            ]);
        }
    }

    public function getUserAccess($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);
            
            $accessData = $user->access;

            return response()->json($accessData);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            \Log::error("Error fetching user access for user ID $id: " . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error fetching user access'], 500);
        }
    }
    
}
