<?php

$modelsDir = __DIR__ . '/app/Models';

$courseModel = file_get_contents($modelsDir . '/Course.php');
$courseModel = str_replace('}', "    public function modules() { return \$this->hasMany(Module::class); }\n    public function schedules() { return \$this->hasMany(Schedule::class); }\n}", $courseModel);
file_put_contents($modelsDir . '/Course.php', $courseModel);

$moduleModel = file_get_contents($modelsDir . '/Module.php');
$moduleModel = str_replace('}', "    public function course() { return \$this->belongsTo(Course::class); }\n    public function challenges() { return \$this->hasMany(Challenge::class); }\n}", $moduleModel);
file_put_contents($modelsDir . '/Module.php', $moduleModel);

$scheduleModel = file_get_contents($modelsDir . '/Schedule.php');
$scheduleModel = str_replace('}', "    public function course() { return \$this->belongsTo(Course::class); }\n    public function mentor() { return \$this->belongsTo(User::class, 'mentor_id'); }\n}", $scheduleModel);
file_put_contents($modelsDir . '/Schedule.php', $scheduleModel);

$challengeModel = file_get_contents($modelsDir . '/Challenge.php');
$challengeModel = str_replace('}', "    public function module() { return \$this->belongsTo(Module::class); }\n}", $challengeModel);
file_put_contents($modelsDir . '/Challenge.php', $challengeModel);

$userModel = file_get_contents($modelsDir . '/User.php');
$userModel = str_replace('}', "    public function progress() { return \$this->hasMany(UserProgress::class); }\n    public function schedulesAsMentor() { return \$this->hasMany(Schedule::class, 'mentor_id'); }\n}", $userModel);
file_put_contents($modelsDir . '/User.php', $userModel);

$upModel = file_get_contents($modelsDir . '/UserProgress.php');
$upModel = str_replace('}', "    public function user() { return \$this->belongsTo(User::class); }\n    public function module() { return \$this->belongsTo(Module::class); }\n}", $upModel);
file_put_contents($modelsDir . '/UserProgress.php', $upModel);

echo "Models updated.";
