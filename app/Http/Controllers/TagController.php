<?php

namespace App\Http\Controllers;
use App\Models\Tags;
use App\Models\Attribute;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tags = Tags::all();
    return view('tags', [
        'tags' => $tags
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'cost' => 'required|numeric',
        ]);
        $attribute = new Tags;
        $attribute->name = $request->input('name');
        $attribute->cost = $request->input('cost');
        $attribute->save();
        return redirect()->back()->with('success', 'Tag created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getTagById(Request $request, $id)
    {
        //
        $tag = Tags::find($id);
    if (!$tag) {
        return response()->json(['error' => 'Tag not found'], 404);
    }
    return response()->json(['tag' => $tag]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $id = $request->input('id');
        $tag = Tags::find($id);

        if (!$tag) {
            return response()->json(['error' => 'Tag not found'], 404);
        }
    
        $tag->name = $request->input('name');
        $tag->cost = $request->input('cost');
        // Update other fields as needed
    
        $tag->save();
        return redirect()->back()->with('success', 'Tag updated successfully.');
    }
    public function deleteTag()
    {
        return view('deleteTag');
    }
    public function deleteTagPost(Request $request)
    {
    $id = $request->input('id');
    $tag = Tags::find($id);

    if (!$tag) {
        return response()->json(['error' => 'Tag not found'], 404);
    }

    $tag->delete();

    return response()->json(['message' => 'Tag deleted successfully',"status" => true]);
}
    public function removeTag()
    {
        return view('removeTag');
    }
    public function removeTagPost(Request $request)
    {
    $id = $request->input('id');
    $number = $request->input('number');
    $nu = '+'.$number;
    $attribute = Attribute::where('user_number', $nu)->first();
    if (!$attribute) {
        return response()->json(['error' => 'Tag not found'.$number], 404);
    }
        $tags=$attribute->tags;
        $tags2 = json_decode($tags);
        $arr=array();
        foreach ($tags2 as $tagValue) {
            if ($tagValue != $id) {
                $arr[]=$tagValue;
            }
        }

        $encod3=json_encode($arr);
        Attribute::where('user_number', $nu)
            ->update([
                'keyword' => $encod3,
                'tags' => $encod3
            ]);
    return response()->json(['message' => 'Tag deleted successfully',"status" => true,'tags'=>$encod3]);
}
}
