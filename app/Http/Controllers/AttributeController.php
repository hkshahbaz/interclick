<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Facades\Log;
class AttributeController extends Controller
{
    public function create()
    {
        return view('conversation.create');
    }

    public function store(Request $request)
    {
        $attribute = new Attribute;
        $attribute->campaign = $request->input('campaign');
        $attribute->source = $request->input('source');
        $attribute->status = 'open';
        $tags = $request->input('tags');
        $attribute->tags = json_encode($tags);
        $attribute->user_number = $request->input('user_number');
        $attribute->save();

        return redirect()->route('conversation');
    }

    public function edit(Attribute $attribute)
    {
        return view('conversation.edit', compact('conversation'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $attribute->campaign = $request->input('campaign');
        $attribute->keyword = $request->input('keyword');
        $attribute->source = $request->input('source');
        $attribute->user_number = $request->input('user_number');
        $attribute->save();

        return redirect()->route('conversation');
    }

    public function update2(Request $request, Attribute $attribute)
    {
        $note = $request->input('note');
        $user_number = $request->input('user_number');
        // Update the attribute table based on the user number
        Attribute::where('user_number', $user_number)
            ->update(['custom_note' => $note]);
        return redirect()->route('conversation');
    }

public function getAttributes()
{
    $attributes = Attribute::all();

    return view('conversation')->with('attributes', $attributes);
}
public function addtags(Request $request, Attribute $attribute)
{
    $attribute = new Attribute;
    $attribute->campaign = $request->input('campaign');
    $attribute->source = $request->input('source');
    $attribute->status = 'open';

    $tags = $request->input('tags');
    $attribute->keyword = json_encode($tags);
    $attribute->tags = json_encode($tags);
    $attribute->user_number = $request->input('user_number');
    $attribute->save();

    return redirect()->route('conversation');
}
public function updatetag(Request $request, Attribute $attribute)
{
    $campaign = $request->input('campaign');
    $source = $request->input('source');
    $user_number = $request->input('user_number');
    $tag = $request->input('tags');
    if (empty($campaign)) {
        $campaign='';
    }
    if (empty($source)) {
        $source='';
    }
    if (!empty($tag)) {
        $tags = json_encode($tag);
        $keyword = json_encode($tag);
    }else{
        $tags=array();
        $keyword=array();
    }
    Attribute::where('user_number', $user_number)
            ->update([
                'campaign' => $campaign,
                'keyword' => $keyword,
                'source' => $source,
                'tags' => $tags
            ]);

    return redirect()->route('conversation');
}


}
