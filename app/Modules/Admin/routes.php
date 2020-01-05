<?php
// This is rout for Admin, mainTeacher and mainStudent module
Route::group(array('module' => 'Admin', 'namespace' => 'App\Modules\Admin\Controllers'), function () {
    Route::group(['middleware' => ['web']], function () {

        //These root are access by those user who has been logged Out.
        Route::group(['middleware' => ['adminGuest']], function () {

            /**
             * Related to Admin login page
             */
            Route::resource('/', 'AdminController@adminLogin');


        });

        //These root are access by those admin user who has been logged In.
        Route::group(['middleware' => ['adminAuth']], function () {

            //--------------------------------Head Menu Tab--------------------------------------------------------------

            /**
             * Related to change language
             */
            Route::get('lang/{locale}', [
                'as' => 'lang',
                'uses' => 'AdminController@changeLang'
            ]);

//--------------------------------Head Menu Tab--------------------------------------------------------------

            /**
             * Related to Admin update password
             */
            Route::resource('/update-password', 'AdminController@UpdatePassword');

            /**
             * Related to Admin profile
             */
            Route::resource('/profile', 'AdminController@adminProfile');

            /**
             * Related to Admin logout
             */
            Route::resource('/logout', 'AdminController@adminLogout');

//-------------------------------Dashboard Tab--------------------------------------------------------------
            /**
             * Related to Admin dashboard page
             */
            Route::resource('/dashboard', 'AdminController@dashboard');

//--------------------------------School Tab--------------------------------------------------------------
            /**
             * Related to School page
             */
            Route::resource('/manage-school', 'SchoolController@manageSchool');
            Route::resource('/add-school', 'SchoolController@addSchool');
            Route::get('/edit-school/{schoolId}', 'SchoolController@editSchool');
            Route::post('/edit-school/{schoolId}', 'SchoolController@editSchool');
            Route::post('/school-ajax-handler', 'SchoolController@schoolAjaxHandler');

//--------------------------------MainTeacher Tab--------------------------------------------------------------
            /**
             * Related to MainTeacher page
             */
            Route::resource('/manage-teacher', 'TeacherController@manageTeacher');
            Route::resource('/add-teacher', 'TeacherController@addTeacher');
            Route::get('/edit-teacher/{teacherId}', 'TeacherController@editTeacher');
            Route::post('/edit-teacher/{teacherId}', 'TeacherController@editTeacher');
            Route::post('/teacher-ajax-handler', 'TeacherController@teacherAjaxHandler');



//--------------------------------MainStudent Tab--------------------------------------------------------------
            /**
             * Related to MainStudent page
             */

            Route::resource('/manage-student', 'StudentController@manageStudent');
            Route::resource('/add-student', 'StudentController@addStudent');
            Route::get('/edit-student/{studentId}', 'StudentController@editStudent');
            Route::post('/edit-student/{studentId}', 'StudentController@editStudent');
            Route::post('/student-ajax-handler', 'StudentController@studentAjaxHandler');



            //--------------------------------MainCourses Tab--------------------------------------------------------------
            /**
             * Related to MainCourses page
             */
             Route::resource('/manage-courses', 'CourseController@manageCourses');
             Route::resource('/add-courses', 'CourseController@addCourses');
             Route::get('/edit-course/{courseId}', 'CourseController@editCourse');
             Route::post('/edit-course/{courseId}', 'CourseController@editCourse');
             Route::post('/course-ajax-handler', 'CourseController@courseAjaxHandler');



            //--------------------------------NormalTeacher Tab--------------------------------------------------------------
            /**
             * Related to MainCourses page
             */

            Route::resource('/manage-normalTeacher', 'NormalTeacherController@manageTeacher');
            Route::resource('/add-normal-teacher', 'NormalTeacherController@addNormalTeacher');
            Route::get('/edit-normalTeacher/{teacherId}', 'NormalTeacherController@editNormalTeacher');
            Route::post('/edit-normalTeacher/{teacherId}', 'NormalTeacherController@editNormalTeacher');
            Route::post('/normalTeacher-ajax-handler', 'NormalTeacherController@normalTeacherAjaxHandler');


//--------------------------------School Course Tab(assignment)--------------------------------------------------------------
            /**
             * Related to School Course page
             */
//            Route::resource('/manage-school-course', 'SchoolCourseController@manageSchoolCourse');


            Route::resource('/add-school-course', 'SchoolCourseController@addSchoolCourse');
            Route::get('/edit-school-course/{courses_relation_id}', 'SchoolCourseController@editSchoolCourse');
            Route::post('/edit-school-course/{courses_relation_id}', 'SchoolCourseController@editSchoolCourse');
            Route::post('/school-course-ajax-handler', 'SchoolCourseController@schoolCourseAjaxHandler');


//--------------------------------School Topic Tab--------------------------------------------------------------
            /**
             * Related to School Course page
             */
              Route::resource('/manage-course-topics', 'TopicController@manageCourseTopics');
              Route::resource('/add-course-topic', 'TopicController@addCourseTopic');
              Route::get('/edit-course-topic/{topicId}', 'TopicController@editTopic');
              Route::post('/edit-course-topic/{topicId}', 'TopicController@editTopic');
//              Route::post('/course-topic-ajax-handler', 'TopicController@topicAjaxHandler');

              Route::post('/course-topic-list-details', 'TopicController@topicDetails');
              Route::resource('/delete-topics', 'TopicController@deleteTopic');


//--------------------------------School Scientific Term Tab--------------------------------------------------------------

            Route::resource('/manage-scientific-term', 'TermController@manageTerm');
            Route::resource('/add-scientific-term', 'TermController@addTerm');
            Route::get('/edit-term/{scientific_terms_id}', 'TermController@editTerm');
            Route::post('/edit-term/{scientific_terms_id}', 'TermController@editTerm');
            Route::post('/term-ajax-handler', 'TermController@termAjaxHandler');



//--------------------------------School Scientific Rule Tab--------------------------------------------------------------

            Route::resource('/manage-scientific-rule', 'RuleController@manageRule');
            Route::resource('/add-scientific-rule', 'RuleController@addRule');
            Route::get('/edit-rule/{scientific_terms_id}', 'RuleController@editRule');
            Route::post('/edit-rule/{scientific_terms_id}', 'RuleController@editRule');
            Route::post('/rule-ajax-handler', 'RuleController@ruleAjaxHandler');




//--------------------------------Report One Tab--------------------------------------------------------------

            Route::resource('/reportOne-details', 'ReportOneController@manageReport');
            Route::post('/report-details', 'ReportOneController@reportDetails');
            Route::get('reportonepdfview',array('as'=>'reportonepdfview','uses'=>'ReportOneController@reportDownload'));


//--------------------------------Report Two Tab--------------------------------------------------------------

            Route::resource('/reportTwo-details', 'ReportTwoController@manageReport');
            Route::post('/report-two-details', 'ReportTwoController@reportDetails');
            Route::get('reporttwopdfview',array('as'=>'reporttwopdfview','uses'=>'ReportTwoController@reportDownload'));



//--------------------------------Report Three Tab--------------------------------------------------------------

            Route::resource('/reportThree-details', 'ReportThreeController@manageReport');
            Route::post('/report-three-details', 'ReportThreeController@reportDetails');
            Route::get('reportthreepdfview',array('as'=>'reportthreepdfview','uses'=>'ReportThreeController@reportDownload'));


//--------------------------------Upload Topic Links & Files--------------------------------------------------------------

            Route::resource('/uploadTopicYouTube', 'UploadController@uploadTopicYouTube');
            Route::resource('/uploadTopicLink', 'UploadController@uploadTopicLink');
            Route::resource('/uploadTopicPpt', 'UploadController@uploadTopicPpt');
            Route::resource('/uploadTopicWord', 'UploadController@uploadTopicWord');
            Route::resource('/uploadTopicPdf', 'UploadController@uploadTopicPdf');



            //--------------------------------Upload Term,Rule Links & Files--------------------------------------------------------------

            Route::resource('/uploadTermYouTube', 'UploadController@uploadTermYouTube');
            Route::resource('/uploadTermLink', 'UploadController@uploadTermLink');
            Route::resource('/uploadTermPpt', 'UploadController@uploadTermPpt');
            Route::resource('/uploadTermWord', 'UploadController@uploadTermWord');
            Route::resource('/uploadTermPdf', 'UploadController@uploadTermPdf');


            /**
             *   Add,edit topics and Scientific Term & Rule
             */

            Route::resource('/add-scientific-term-rule', 'SchoolCourseController@addScientificTermRule');
            Route::get('/edit-course-topic/{schools_id}/{teaching_stage_id}/{courses_id}/{topic_id}', 'SchoolCourseController@editCourseTopic');
            Route::post('/edit-course-topic/{schools_id}/{teaching_stage_id}/{courses_id}/{topic_id}', 'SchoolCourseController@editCourseTopic');
            Route::get('/edit-topic-scientificTermRule/{scientific_term_per_topic_id}', 'SchoolCourseController@editTopicScientificTermRule');
            Route::post('/edit-topic-scientificTermRule/{scientific_term_per_topic_id}', 'SchoolCourseController@editTopicScientificTermRule');


            /**
             *   Manage the Topic List
             */

            Route::get('/manage-topic-list/{schoolId}/{stageId}/{courseId}', 'SchoolCourseController@manageTopicList');
            Route::post('/manage-topic-list/{schoolId}/{stageId}/{courseId}', 'SchoolCourseController@manageTopicList');

            /**
             *   Manage the Scientific Term & Rule
             */
            Route::get('/manage-term-list/{schoolId}/{stageId}/{courseId}/{topicId}', 'SchoolCourseController@manageTermList');
            Route::post('/manage-term-list/{schoolId}/{stageId}/{courseId}/{topicId}', 'SchoolCourseController@manageTermList');



            /**
             * Related to dropdown Value according to school,course,topic,scientific term
             */
            Route::resource('/courses-per-school','SchoolCourseController@coursesPerSchool');
            Route::resource('/topic-per-courses','SchoolCourseController@topicPerCourses');
            Route::resource('/normalteacher-per-school','SchoolCourseController@normalTeacherPerSchool');
            Route::resource('/term-courses-per-school','SchoolCourseController@termCoursesPerSchool');
            Route::resource('/rule-per-terms','SchoolCourseController@rulePerTerms');



            //For display Courses Name on Sub-Screen
            Route::resource('/topic_course_name','SchoolCourseController@topicCourseName');
            Route::resource('/termRule_topic_name','SchoolCourseController@termRuleTopicName');


            Route::resource('/addNewTopicInCourse','SchoolCourseController@addNewTopicInCourse');

            Route::resource('/addNewTermInTopic','SchoolCourseController@addNewTermInTopic');




            //For download File on Dashboard
            Route::resource('/get_mswordfile','SchoolCourseController@getMswordfile');
            Route::resource('/get_mswordfile_b','SchoolCourseController@getmswordfileb');
            Route::resource('/get_mypdf_a','SchoolCourseController@getmypdfa');
            Route::resource('/get_mypdf_b','SchoolCourseController@getmypdfb');


            //For download Link and File on Topic Sub-Screen
            Route::resource('/get_topic_utube_link','SchoolCourseController@getTopicUtubeLink');
            Route::resource('/get_topic_simple_link','SchoolCourseController@getTopicSimpleLink');
            Route::resource('/get_topic_ppt_file','SchoolCourseController@getTopicPptFile');
            Route::resource('/get_topic_word_file','SchoolCourseController@getTopicWordFile');
            Route::resource('/get_topic_pdf_file','SchoolCourseController@getTopicPdfFile');




            //For download Link and File on Term & Rule Sub-Screen

            Route::resource('/get_rule_utube_link','SchoolCourseController@getRuleUtubeLink');
            Route::resource('/get_rule_simple_link','SchoolCourseController@getRuleSimpleLink');
            Route::resource('/get_rule_ppt_file','SchoolCourseController@getRulePptFile');
            Route::resource('/get_rule_word_file','SchoolCourseController@getRuleWordFile');
            Route::resource('/get_rule_pdf_file','SchoolCourseController@getRulePdfFile');



            //For Hebrew Language
            Route::get('/lang/pagination/{item}', function($item)
            {
                return trans('pagination.'.$item);
            });



//------------------------------Extra----------------------------------------------------------------
            /**
             * Related to fetch image of storage folder
             */
            Route::get('/image/{filePath}', function ($filePath) {
                $filePath = explode("_", $filePath);
                $filePath = implode('/', $filePath);
                $filePath = storage_path() . '/' . $filePath;
                $file = File::get($filePath);
                $type = File::mimeType($filePath);
                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);
                return $response;
            });

        });
    });
});