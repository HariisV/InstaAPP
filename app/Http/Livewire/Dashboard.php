<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Post, Like, Comment};
use Livewire\WithFileUploads;
class Dashboard extends Component
{
    use WithFileUploads;

    public $new_post = [
        'image' => null,
        'can_comment' => true,
        'description' => ''
    ];

    public $new_comment = [];

    public $all_post = [];

    public function reget_data(){
        $this->all_post = Post::orderBy('created_at', 'desc')->with('likes')->with('comments')->get();
    }

    public function mount(){
        $this->reget_data();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
    
    public function new_post(){

        $this->validate([
            'new_post.description' => ['required', 'string'],
            'new_post.image' => ['nullable', 'mimes:jpg,jpeg,png,svg', 'max:5120'],
        ], [], [
            'new_post.description' => 'Description',
            'new_post.image' => 'Image',
        ]);


        if ($this->new_post['image']) {
            $this->new_post['image'] = $this->new_post['image']->storeAs('post-image', 'post-image-' . time() . '.' . $this->new_post['image']->extension(), 'public');
        }

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'image' => $this->new_post['image'],
            'can_comment' => $this->new_post['can_comment'],
            'description' => $this->new_post['description']
        ]);

        $this->reget_data();
        $this->new_post = [
            'image' => null,
            'can_comment' => true,
            'description' => ''
        ];
    }

    public function like_post($id){
        $like = Like::where('user_id', auth()->user()->id)->where('post_id', $id)->first();
        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $id
            ]);
        }
        $this->reget_data();
    }

    public function new_comment($id){
        $this->validate([
            'new_comment.'.$id => ['required', 'string'],
        ], [], [
            'new_comment.'.$id => 'Comment',
        ]);
        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $id,
            'comment' => $this->new_comment[$id]
        ]);
        $this->reget_data();
        $this->new_comment[$id] = '';
    }

    public function delete_post($id){
        $post = Post::find($id);

        
        if ($post) {
            if ($post->image) {
                unlink(storage_path('app/public/' . $post->image));
            }
            $post->delete();
        }
        $this->reget_data();
    }
}
