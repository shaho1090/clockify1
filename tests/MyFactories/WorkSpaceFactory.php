<?php


namespace Tests\MyFactories;

use App\Project;
use App\Tag;
use App\User;
use App\WorkSpace;
use Faker\Test\Provider\BaseTest;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Support\Str;
use Tests\CreatesApplication;

class WorkSpaceFactory
{
    use InteractsWithAuthentication;

    protected $user = null;

    protected $tagsCount = 0;

    protected $projectsCount = 0;

    protected $membersCount = 0;


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

    public function withMembers(int $count)
    {
        $this->membersCount = $count;

        return $this;
    }

    public function create()
    {

        if ($this->user === null) {

            $user = factory(User::class)->create();

            $this->actingAs($user);
        }

        $workSpace = $this->user->addWorkSpace();

        factory(Tag::class, $this->tagsCount)->create([
            'work_space_id' => $workSpace->id,
        ]);

        factory(Project::class, $this->projectsCount)->create([
            'work_space_id' => $workSpace->id,
        ]);

        return $workSpace;
    }
}
