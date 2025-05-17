<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    //
    public function index()
    {
        # code...
        $templates = Template::all();
        return view("template.create-template", [
            'templates' => $templates
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => "required",
            'description' => "required",
        ]);

        Template::create($request->all());
        return redirect()->route("template.index");
    }

    public function delete($id)
    {
        $template = Template::find($id);
        $template->delete();
        return redirect()->route("template.index");
    }
}
