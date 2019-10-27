<?php

namespace App\Http\Controllers;

use App\Contributor;
use App\Http\Requests\ContributorFormRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ContributorsController extends Controller
{
    public function add(ContributorFormRequest $request)
    {
        $contributor = new Contributor(array(
            'project_id' => $request->get('project_id'),
            'contributor' => Auth::user()->id,
        ));
        $contributor->save();
        //باید ادر اینجا کنترلر کانتربیوتر صدا زده شده و خود ایجاد کننده پروژه به عنوان اولین نفر به لیست مشارکت کنندگان اضافه شود
        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }
}
