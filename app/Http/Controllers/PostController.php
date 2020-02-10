<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use DB;
use App\Post; //bring my post model

class PostController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    //add constructor to prevent middleware fuctions from unlogged-in users (guests)
    //exp : posts/create -> redirect to login view
    //for guest view (view profile as public..) we addd exception for allowed view pages
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //using Eloquent ORM we can use model func.s
        //$myUsers = User::all();
        //        $myUsers = User::all()->take(1); //teke the 1.st //can be added to other func //take(>n) donsnt give error
        //$myUsers = DB::select ('select * from user');
        // $myUsers = User::orderBy('first_name','asc')->take(0)->get();
        //$myUsers = User::where('first_name','alaa')->get();//select user where name = .. //->get() is to make result as array
        //$myUsers = User::orderBy('first_name', 'asc')->paginate(6); //page style with 1 user per page
         $postlist = Post::orderBy('updated_at','asc')->paginate(5);
 //       $postlist= Post::all();
        return  view('Posts.index')->with('posts',$postlist);
    }

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
            $path = $request->file('cover_image')->storeAs('storage/images/post_images',$fileNameToStore);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('Posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //check for correct user:
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        return view('Posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [     // (request,[rules])
            'content' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //update post:
        $post = Post::find($id);
        $post->categories = $request->input('categ');
        $post->content = $request->input('content');
        //handle file upload :
        if($request->hasfile('cover_image')){
            if($post->attachment != 'noimage.jpg'){
                //delete the old attachment:
                Storage::delete('public/cover_images/'.$post->attachment);
            }
            $filenameWithExt= $request->file('cover_image')->getClientOriginalName();
            $filename =pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //  define unique file name with timestamp :
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
            $post->attachment = $fileNameToStore;
        }else{
            //$fileNameToStore= 'noimage.jpg'; //the deflt img when no img uploaded
            //dont delete if there is an uploaded image
        }

        $post->save();
        return  redirect('/posts')->with('success', 'Post Updated');
    }

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
