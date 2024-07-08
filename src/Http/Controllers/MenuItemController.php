<?php

namespace Tarique\MenuBuilder\Http\Controllers;

use Tarique\MenuBuilder\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    public function reorder(Request $request)
    {
        $parentId = $request->input('parent_id');
        $children = $request->input('children');
        
        foreach ($children as $order => $id) {
            MenuItem::where('id', $id)->update([
                'order' => $order,
                'parent_id' => $parentId,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
