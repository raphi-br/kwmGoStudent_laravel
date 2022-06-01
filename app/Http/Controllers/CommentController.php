<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{

    private function parseRequest(Request $request) : Request{
        $date = new \DateTime($request->created_at);
        $request['created_at'] = $date;
        return $request;
    }

    public function createComment (Request $request) : JsonResponse{
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $comment = Comment::create($request->all());
            DB::commit();
            return response()->json($comment, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json('saving comment failed'.$e->getMessage(), 420);
        }
    }

    public function deleteComment($id): JsonResponse{
        $comment = Comment::where('id', $id)->first();
        if ($comment != null) {
            $comment->delete();
        }
        else
            throw new \Exception("Comment couldn't be deleted - it does not exist");
        return response()->json('Comment (' . $id . ') successfully deleted', 200);

    }
}
