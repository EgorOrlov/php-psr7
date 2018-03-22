<?php

namespace App\Http\Action\Blog;

use ...;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        
        if ($id > 5){
            return new JsonResponse(['error'=> 'Underfined Page'], 404);
        }
        
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}