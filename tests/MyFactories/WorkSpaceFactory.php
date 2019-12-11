<?php


namespace Tests\MyFactories;


use App\Project;
use App\Tag;
use App\User;
use App\WorkSpace;
use Illuminate\Support\Str;

class WorkSpaceFactory
{
    protected $user = null;

    protected $tagsCount = 0;

    protected $projectsCount = 0;

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTags(int $count)
    {
        $this->tagsCount = $count;

        return $this;
    }

    public function withProjects(int $count)
    {
        $this->projectsCount = $count;

        return $this;
    }

    public function create()
    {
        $user = $this->user ?? factory(User::class)->create();

        $workSpace = $user->addWorkSpace();

        factory(Tag::class, $this->tagsCount)->create([
            'work_space_id' => $workSpace->id,
        ]);

        factory(Project::class, $this->projectsCount)->create([
            'work_space_id' => $workSpace->id,
        ]);

       // $user->workSpaces()->create(['title' => 'Test']);



        return $workSpace;
    }
}
