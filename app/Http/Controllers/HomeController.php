<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['showTimeline']]);//except those methods, non authed user cannot access

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('timeline')->with('user',$user);
    }

    public function showTimeline($user_id)//open public/auth user profile
    {
        $user = User::find($user_id);
        return view('timeline')->with('user',$user);
    }

//________________________________________________________________________
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [  // (request,[rules])
            //'categ' => 'required',
            'content' => 'required',
            'cover_image' => 'image|nullable|max:1999' //it has to be an image type(png..)
            //max size: 1999 most of apache server's default upload size is 2MB
        ]);
        //handle file upload :
        if($request->hasfile('cover_image')){ //the user had selectes somthing
            //get filename with extension:
            $filenameWithExt= $request->file('cover_image')->getClientOriginalName();
            //can not insert it directly to DB bec. there can be 2 files w. same names->
            //pathinfo: php function, no laravel
            $filename =pathinfo($filenameWithExt, PATHINFO_FILENAME);  //get only file name
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //  define unique file name with timestamp :
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
                    //  it will go to storage/app/public and create folder for all c.imgs
                    //but storage is not accessable through the browser so we link the storage to myapp/public file

        }else{
            $fileNameToStore= 'noimage.jpg'; //the deflt img when no img uploaded
        }
        //create post:
        $newpost = new Post();
        $newpost->categories = $request->input('categ');
        $newpost->content = $request->input('content');
        $newpost->user_id = auth()->user()->id; //it is not coming from the request form, from logged-in user
        $newpost->attachment = $fileNameToStore;
        $newpost->save();

        return  redirect('/posts')->with('success', 'Post created');
    }


//__________________________________________________________________________________
  /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($part) //edit-profile - basic/interest/books..
    {//this method can not be reached by unauth user
        $auth_id = auth()->user()->id;
        $auth_user = User::find($auth_id);
        return view('profile-edit.edit-'.$part)->with('user',$auth_user);//!!! no need to user->auth->user()..

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [  // (request,[rules])
            'bio' =>'nullable|max:199',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
              'Email' => 'required|max:320|email|unique:users,email,'.auth()->user()->id.',id', //unique:table,column,except,idColumn
    //          'day' => 'required',
    //         'month' => 'required',
    //        'year' => 'required',
    //       'gender' => 'required',
    //       'country' => 'required',
    //       'city' => 'required',
           'user_image' => 'nullable|image|max:1999',
           'profile_cover' => 'image|nullable|max:1999',
        ]);
        //update profile:
        $auth_id = auth()->user()->id;
        $user = User::find($auth_id);

          //handle file upload :
          if($request->hasfile('user_image')){
            if($user->profile_photo != 'noimage.jpg' || $user->profile_photo != NULL){
                //delete the old attachment:
                Storage::delete('public/images/profiles/user_images/'.$user->profile_photo);
            }
            $filenameWithExt= $request->file('user_image')->getClientOriginalName();
            $filename =pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('user_image')->getClientOriginalExtension();
            //  define unique file name with timestamp :
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('user_image')->storeAs('public/images/profiles/user_images/',$fileNameToStore);
            $user->profile_photo = $fileNameToStore;
        }else{
            //$fileNameToStore= 'noimage.jpg'; //the deflt img when no img uploaded
            //dont delete if there is an uploaded image
          //  return  redirect('/profile/edit-basic')->with('error', 'Not Able to Upload User Image');
        }
        if($request->hasfile('profile_cover')){
            if($user->profile_cover != 'noimage.jpg' || $user->profile_cover != NULL){
                //delete the old attachment:
                Storage::delete('public/images/profiles/cover_images/'.$user->profile_cover);
            }
            $filenameWithExt= $request->file('profile_cover')->getClientOriginalName();
            $filename =pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_cover')->getClientOriginalExtension();
            //  define unique file name with timestamp :
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('profile_cover')->storeAs('public/images/profiles/cover_images/',$fileNameToStore);
            $user->profile_cover = $fileNameToStore;
        }else{
            //$fileNameToStore= 'noimage.jpg'; //the deflt img when no img uploaded
            //dont delete if there is an uploaded image
        }
        $user->bio = $request->input('bio');
        $user->first_name = $request->input('firstname');
        $user->last_name = $request->input('lastname');
        $user->email = $request->input('Email');
        $user->birth_date = date("Y-m-d",strtotime($request->input('year')."-".$request->input('month')."-".$request->input('day')));
        $user->gender = $request->input('gender');
        //dd($request); //print req
        $user->save();
        return  redirect('/profile/edit-basic')->with('success', 'Profile Updated');
    }

//_________________________________________________________________________

  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

           //check for correct user: //no /delete link but a direct request could be sent to delete post
            if(auth()->user()->id != $post->user_id){
                return redirect('/posts')->with('error','Unauthorized page');
            }
            if($post->attachment != 'noimage.jpg'){
                //delete the img
                Storage::delete('public/cover_images/'.$post->attachment);
                //with use Illumiante\Support\Facades\Storage;
            }
            $post->delete();
        return redirect('/posts')->with('success','Post Has Deleted');
    }










}
