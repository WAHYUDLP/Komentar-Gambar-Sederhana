<?php



namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image_id' => 'required|exists:images,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'image_id' => $request->image_id,
            'content' => $request->content,
        ]);

        // Update image updated_at untuk sorting
        Image::find($request->image_id)->touch();

        return redirect('/')->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return redirect('/')->with('error', 'Anda tidak dapat menghapus komentar orang lain!');
        }

        $comment->delete();

        return redirect('/')->with('success', 'Komentar berhasil dihapus!');
    }
}