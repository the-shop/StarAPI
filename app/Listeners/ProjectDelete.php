<?php

namespace App\Listeners;

use App\GenericModel;

class ProjectDelete
{
    /**
     * Handle the event.
     * @param \App\Events\ProjectDelete $event
     */
    public function handle(\App\Events\ProjectDelete $event)
    {
        $project = $event->model;

        //check if project is deleted or restored to get all sprints from proper collection
        $project['collection'] === 'projects_deleted' ?
            GenericModel::setCollection('sprints')
            : GenericModel::setCollection('sprints_deleted');

        $projectSprints = GenericModel::where('project_id', '=', $project->id)->get();

        //delete or restore project sprints
        foreach ($projectSprints as $sprint) {
            $project['collection'] === 'projects_deleted' ? $sprint->delete() : $sprint->restore();
        }

        //check if project is deleted or restored to get all tasks from proper collection
        $project['collection'] === 'projects_deleted' ?
            GenericModel::setCollection('tasks')
            : GenericModel::setCollection('tasks_deleted');

        $projectTasks = GenericModel::where('project_id', '=', $project->id)->get();

        //delete or restore project tasks
        foreach ($projectTasks as $task) {
            $project['collection'] === 'projects_deleted' ? $task->delete() : $task->restore();
        }
    }
}
