<?php

namespace Tests\GenericModel;

use Tests\Collections\ProjectRelated;
use Tests\TestCase;
use App\GenericModel;

class GenericModelTest extends TestCase
{
    use ProjectRelated;

    /**
     * Test model archive
     */
    public function testGenericModelArchive()
    {
        $project = $this->getNewProject();
        $project->save();

        $projectId = $project->id;
        $project->archive();

        GenericModel::setCollection('projects');
        $oldProject = GenericModel::find($projectId);

        GenericModel::setCollection('projects_archived');
        $foundArchivedProject = GenericModel::find($projectId);

        $this->assertEquals($projectId, $foundArchivedProject->id);
        $this->assertEquals(null, $oldProject);
    }

    /**
     * Test model unArchive with wrong collection - exception error
     */
    public function testGenericModelArchiveWrongCollection()
    {
        $project = $this->getNewArchivedProject();
        $project->save();

        $this->setExpectedException('Exception', 'Model collection now allowed to archive', 403);
        $project->archive();
    }

    /**
     * Test model unArchive
     */
    public function testGenericModelUnArchive()
    {
        $project = $this->getNewArchivedProject();
        $project->save();

        $archivedProjectId = $project->id;

        $project->unArchive();

        GenericModel::setCollection('projects_archived');
        $archivedProject = GenericModel::find($archivedProjectId);

        GenericModel::setCollection('projects');
        $foundProject = GenericModel::find($archivedProjectId);

        $this->assertEquals($archivedProjectId, $foundProject->id);
        $this->assertEquals(null, $archivedProject);
    }

    /**
     * Test model unArchive with wrong collection - exception error
     */
    public function testGenericModelUnArchiveWrongCollection()
    {
        $project = $this->getNewProject();
        $project->save();

        $this->setExpectedException('Exception', 'Model collection now allowed to unArchive', 403);
        $project->unarchive();
    }

    /**
     * Test GenericModel delete
     */
    public function testGenericModelDelete()
    {
        $project = $this->getNewProject();
        $project->save();

        $projectId = $project->id;
        $project->delete();

        GenericModel::setCollection('projects');
        $oldProject = GenericModel::find($projectId);

        GenericModel::setCollection('projects_deleted');
        $foundDeletedProject = GenericModel::find($projectId);

        $this->assertEquals($projectId, $foundDeletedProject->id);
        $this->assertEquals(null, $oldProject);
    }

    /**
     * Test model unArchive with wrong collection - exception error
     */
    public function testGenericModelDeleteWrongCollection()
    {
        $project = $this->getNewDeletedProject();
        $project->save();

        $this->setExpectedException('Exception', 'Model collection now allowed to delete', 403);
        $project->delete();
    }

    /**
     * Test model unArchive
     */
    public function testGenericModelRestore()
    {
        $project = $this->getNewDeletedProject();
        $project->save();

        $deletedProjectId = $project->id;

        $project->restore();

        GenericModel::setCollection('projects_deleted');
        $deletedProject = GenericModel::find($deletedProjectId);

        GenericModel::setCollection('projects');
        $foundRestoredProject = GenericModel::find($deletedProjectId);

        $this->assertEquals($deletedProjectId, $foundRestoredProject->id);
        $this->assertEquals(null, $deletedProject);
    }

    /**
     * Test model unArchive with wrong collection - exception error
     */
    public function testGenericModelRestoreWrongCollection()
    {
        $project = $this->getNewProject();
        $project->save();

        $this->setExpectedException('Exception', 'Model collection now allowed to restore', 403);
        $project->restore();
    }
}
