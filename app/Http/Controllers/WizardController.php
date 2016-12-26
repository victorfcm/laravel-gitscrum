<?php

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Models\ProductBacklog;
use Auth;

class WizardController extends Controller
{
    public function step1()
    {
        $repositories = (object) app(Auth::user()->provider)->readRepositories();
        $currentRepositories = ProductBacklog::all();

        \Session::put('Repositories', $repositories);

        return view('wizard.step1')
            ->with('repositories', $repositories)
            ->with('currentRepositories', $currentRepositories)
            ->with('columns', ['checkbox', 'repository', 'organization']);
    }

    public function step2(Request $request)
    {
        $repositories = \Session::get('Repositories')->whereIn('provider_id', $request->repos);
        foreach ($repositories as $repository) {
            try {
                app(Auth::user()->provider)->readCollaborators($repository->organization_title, $repository->title, $repository->provider_id);
                $product_backlog = ProductBacklog::create(get_object_vars($repository));
                app(Auth::user()->provider)->createBranches($repository->organization_title, $product_backlog->id, $repository->title);
            } catch (\Illuminate\Database\QueryException $e) {
            }
        }

        return view('wizard.step2')
            ->with('repositories', $repositories)
            ->with('columns', ['repository', 'organization']);
    }

    public function step3()
    {
        $result = app(Auth::user()->provider)->readIssues();

        return redirect()->route('issues.index', ['slug' => 0]);
    }
}
