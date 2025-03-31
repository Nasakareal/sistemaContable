<?php

return [
    /*
     * If set to false, no activities will be logged.
     */
    'enabled' => true,

    /*
     * The default log name that will be used if none is provided.
     */
    'default_log_name' => 'default',

    /*
     * The class name of the activity model.
     */
    'activity_model' => \Spatie\Activitylog\Models\Activity::class,

    /*
     * Which attributes should be logged by default.
     */
    'default_attributes' => ['*'],

    /*
     * If set to true, only changed attributes are logged.
     */
    'log_only_dirty' => false,

    /*
     * If set to true, empty values won't be saved to the database.
     */
    'submit_empty_logs' => false,
];
