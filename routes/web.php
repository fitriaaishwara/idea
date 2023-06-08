<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

    //User
    Route::get('/user', [App\Http\Controllers\Web\UserController::class, 'index'])->name('user');
    Route::post('/user/getData', [App\Http\Controllers\Web\UserController::class, 'getData'])->name('user/getData');
    Route::get('/user/{id}', [App\Http\Controllers\Web\UserController::class, 'show'])->name('user/show');
    Route::post('/user/store', [App\Http\Controllers\Web\UserController::class, 'store'])->name('user/store');
    Route::post('/user/update', [App\Http\Controllers\Web\UserController::class, 'update'])->name('user/update');
    Route::post('/user/password', [App\Http\Controllers\Web\UserController::class, 'changePassword'])->name('user/password');
    Route::post('/user/updateActive', [App\Http\Controllers\Web\UserController::class, 'updateActive'])->name('user/updateActive');
    Route::post('/user/delete/{id}', [App\Http\Controllers\Web\UserController::class, 'destroy'])->name('user/delete');

    //Role
    Route::get('/role', [App\Http\Controllers\Web\RoleController::class, 'index'])->name('role');
    Route::post('/role', [App\Http\Controllers\Web\RoleController::class, 'getData'])->name('role/getData');
    Route::get('/role/create', [App\Http\Controllers\Web\RoleController::class, 'create'])->name('role/create');
    Route::post('/role/create', [App\Http\Controllers\Web\RoleController::class, 'store'])->name('role/create');
    Route::get('/role/edit/{id}', [App\Http\Controllers\Web\RoleController::class, 'edit'])->name('role/edit');
    Route::post('/role/edit/{id}', [App\Http\Controllers\Web\RoleController::class, 'update'])->name('role/edit');
    Route::post('/role/delete/{id}', [App\Http\Controllers\Web\RoleController::class, 'destroy'])->name('role/delete');

    //Scope
    Route::get('/scope', [App\Http\Controllers\Web\ScopeController::class, 'index'])->name('scope');
    Route::post('/scope/getData', [App\Http\Controllers\Web\ScopeController::class, 'getData'])->name('scope/getData');
    Route::post('/scope/store', [App\Http\Controllers\Web\ScopeController::class, 'store'])->name('scope/store');
    Route::post('/scope/update', [App\Http\Controllers\Web\ScopeController::class, 'update'])->name('scope/update');
    Route::get('/scope/{id}', [App\Http\Controllers\Web\ScopeController::class, 'show'])->name('scope/show');
    Route::post('/scope/delete/{id}', [App\Http\Controllers\Web\ScopeController::class, 'destroy'])->name('scope/delete');

    //Client
    Route::get('/client', [App\Http\Controllers\Web\ClientController::class, 'index'])->name('client');
    Route::post('/client/getData', [App\Http\Controllers\Web\ClientController::class, 'getData'])->name('client/getData');
    Route::get('/client/show/{id}', [App\Http\Controllers\Web\ClientController::class, 'show'])->name('client/show');
    Route::get('/client/create', [App\Http\Controllers\Web\ClientController::class, 'create'])->name('client/create');
    Route::post('/client/create', [App\Http\Controllers\Web\ClientController::class, 'store'])->name('client/create');
    Route::get('/client/detail/{id}', [App\Http\Controllers\Web\ClientController::class, 'detail'])->name('client/detail');
    Route::get('/client/edit/{id}', [App\Http\Controllers\Web\ClientController::class, 'edit'])->name('client/edit');
    Route::post('/client/edit/{id}', [App\Http\Controllers\Web\ClientController::class, 'update'])->name('client/edit');
    Route::post('/client/delete/{id}', [App\Http\Controllers\Web\ClientController::class, 'destroy'])->name('client/delete');
    Route::post('/client/follow-up', [App\Http\Controllers\Web\ClientController::class, 'followUp'])->name('client/follow-up');
    Route::post('/client/follow-up/getData', [App\Http\Controllers\Web\ClientController::class, 'getDataFollowUp'])->name('client/follow-up/getData');
    Route::get('/client/detail/follow-up/{id}', [App\Http\Controllers\Web\ClientController::class, 'detailFollowUp'])->name('client/detail/follow-up');
    Route::get('/client/follow-up/download/{id}', [App\Http\Controllers\Web\ClientController::class, 'downloadAttachmentFollowUp'])->name('client/follow-up/download');
    Route::post('/client/win', [App\Http\Controllers\Web\ClientController::class, 'win'])->name('client/win');
    Route::post('/client/import', [App\Http\Controllers\Web\ClientController::class, 'import'])->name('client/import');
    Route::post('/client/export', [App\Http\Controllers\Web\ClientController::class, 'export'])->name('client/export');
    Route::post('/client/import/bouncing', [App\Http\Controllers\Web\ClientController::class, 'importBouncing'])->name('client/import/bouncing');
    Route::post('/client/import/update', [App\Http\Controllers\Web\ClientController::class, 'importUpdate'])->name('client/import/update');

    //Client Win
    Route::get('/client-win', [App\Http\Controllers\Web\ClientWinController::class, 'index'])->name('client-win');
    Route::post('/client-win/getData', [App\Http\Controllers\Web\ClientWinController::class, 'getData'])->name('client-win/getData');
    Route::get('/client-win/show/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'show'])->name('client-win/show');
    Route::get('/client-win/detail/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'detail'])->name('client-win/detail');
    Route::get('/client-win/edit/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'edit'])->name('client-win/edit');
    Route::post('/client-win/edit/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'update'])->name('client-win/edit');
    Route::post('/client-win/delete/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'destroy'])->name('client-win/delete');
    Route::post('/client-win/follow-up', [App\Http\Controllers\Web\ClientWinController::class, 'followUp'])->name('client-win/follow-up');
    Route::post('/client-win/follow-up/getData', [App\Http\Controllers\Web\ClientWinController::class, 'getDataFollowUp'])->name('client-win/follow-up/getData');
    Route::get('/client-win/detail/follow-up/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'detailFollowUp'])->name('client-win/detail/follow-up');
    Route::get('/client-win/follow-up/download/{id}', [App\Http\Controllers\Web\ClientWinController::class, 'downloadAttachmentFollowUp'])->name('client-win/follow-up/download');

    //Follow Up Client
    Route::get('/follow-up-client', [App\Http\Controllers\Web\FollowUpClientController::class, 'index'])->name('follow-up-client');
    Route::post('/follow-up-client/getData', [App\Http\Controllers\Web\FollowUpClientController::class, 'getData'])->name('follow-up-client/getData');
    Route::post('/follow-up-client/export/report', [App\Http\Controllers\Web\FollowUpClientController::class, 'exportReport'])->name('follow-up-client/export/report');

    //Ajax
    Route::post('/ajax/getDataProvince', [App\Http\Controllers\Web\AjaxController::class, 'getDataProvince'])->name('ajax/getDataProvince');
    Route::post('/ajax/getDataRegency', [App\Http\Controllers\Web\AjaxController::class, 'getDataRegency'])->name('ajax/getDataRegency');
    Route::post('/ajax/getDataDistrict', [App\Http\Controllers\Web\AjaxController::class, 'getDataDistrict'])->name('ajax/getDataDistrict');
    Route::post('/ajax/getDataVillage', [App\Http\Controllers\Web\AjaxController::class, 'getDataVillage'])->name('ajax/getDataVillage');
    Route::post('/ajax/getDataSchedule', [App\Http\Controllers\Web\AjaxController::class, 'getDataSchedule'])->name('ajax/getDataSchedule');
    Route::post('/ajax/getDataScheduleAccreditation', [App\Http\Controllers\Web\AjaxController::class, 'getDataScheduleAccreditation'])->name('ajax/getDataScheduleAccreditation');

    //Monitoring Client
    Route::post('/monitoring-client/getData', [App\Http\Controllers\Web\MonitoringClientController::class, 'getData'])->name('monitoring-client/getData');

    //Monitoring Project
    Route::get('/monitoring-project', [App\Http\Controllers\Web\MonitoringProjectController::class, 'index'])->name('monitoring-project');
    Route::post('/monitoring-project/getData', [App\Http\Controllers\Web\MonitoringProjectController::class, 'getData'])->name('monitoring-project/getData');
    Route::get('/monitoring-project/show/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'show'])->name('monitoring-project/show');
    Route::get('/monitoring-project/create', [App\Http\Controllers\Web\MonitoringProjectController::class, 'create'])->name('monitoring-project/create');
    Route::post('/monitoring-project/create', [App\Http\Controllers\Web\MonitoringProjectController::class, 'store'])->name('monitoring-project/create');
    Route::get('/monitoring-project/detail/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'detail'])->name('monitoring-project/detail');
    Route::get('/monitoring-project/edit/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'edit'])->name('monitoring-project/edit');
    Route::post('/monitoring-project/edit/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'update'])->name('monitoring-project/edit');
    Route::post('/monitoring-project/delete/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'destroy'])->name('monitoring-project/delete');
    Route::post('/monitoring-project/activity', [App\Http\Controllers\Web\MonitoringProjectController::class, 'activity'])->name('monitoring-project/activity');
    Route::get('/monitoring-project/total/activity/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'totalActivity'])->name('monitoring-project/total/activity');
    Route::get('/monitoring-project/meeting/{id}', [App\Http\Controllers\Web\MonitoringProjectController::class, 'meeting'])->name('monitoring-project/meeting');

    Route::get('/monitoring-project-finish', [App\Http\Controllers\Web\MonitoringProjectFinishController::class, 'index'])->name('monitoring-project-finish');
    Route::post('/monitoring-project-finish/getData', [App\Http\Controllers\Web\MonitoringProjectFinishController::class, 'getData'])->name('monitoring-project-finish/getData');
    Route::get('/monitoring-project-finish/show/{id}', [App\Http\Controllers\Web\MonitoringProjectFinishController::class, 'show'])->name('monitoring-project-finish/show');
    Route::get('/monitoring-project-finish/detail/{id}', [App\Http\Controllers\Web\MonitoringProjectFinishController::class, 'detail'])->name('monitoring-project-finish/detail');
    Route::get('/monitoring-project-finish/meeting/{id}', [App\Http\Controllers\Web\MonitoringProjectFinishController::class, 'meeting'])->name('monitoring-project-finish/meeting');

    //Monitoring Project Detail
    Route::post('/monitoring-project-detail/getData', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'getData'])->name('monitoring-project-detail/getData');
    Route::post('/monitoring-project-detail/store', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'store'])->name('monitoring-project-detail/store');
    Route::post('/monitoring-project-detail/update', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'update'])->name('monitoring-project-detail/update');
    Route::get('/monitoring-project-detail/show/{id}', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'show'])->name('monitoring-project-detail/show');
    Route::post('/monitoring-project-detail/delete/{id}', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'destroy'])->name('monitoring-project-detail/delete');
    Route::get('/monitoring-project-detail/download/{id}', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'download'])->name('monitoring-project-detail/download');
    Route::post('/monitoring-project-detail/move', [App\Http\Controllers\Web\MonitoringProjectDetailController::class, 'move'])->name('monitoring-project-detail/move');

    //Monitoring Project Meeting
    Route::post('/monitoring-project-meeting/getData', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'getData'])->name('monitoring-project-meeting/getData');
    Route::get('/monitoring-project-meeting/create/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'create'])->name('monitoring-project-meeting/create');
    Route::post('/monitoring-project-meeting/store', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'store'])->name('monitoring-project-meeting/store');
    Route::post('/monitoring-project-meeting/update', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'update'])->name('monitoring-project-meeting/update');
    Route::get('/monitoring-project-meeting/edit/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'edit'])->name('monitoring-project-meeting/edit');
    Route::get('/monitoring-project-meeting/detail/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'detail'])->name('monitoring-project-meeting/detail');
    Route::get('/monitoring-project-meeting/show/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'show'])->name('monitoring-project-meeting/show');
    Route::post('/monitoring-project-meeting/delete/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'destroy'])->name('monitoring-project-meeting/delete');
    Route::get('/monitoring-project-meeting/download/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingController::class, 'download'])->name('monitoring-project-meeting/download');

    //Monitoring Project Meeting Participant
    Route::post('/monitoring-project-meeting-participant/getData', [App\Http\Controllers\Web\MonitoringProjectMeetingParticipantController::class, 'getData'])->name('monitoring-project-meeting-participant/getData');
    Route::post('/monitoring-project-meeting-participant/store', [App\Http\Controllers\Web\MonitoringProjectMeetingParticipantController::class, 'store'])->name('monitoring-project-meeting-participant/store');
    Route::post('/monitoring-project-meeting-participant/update', [App\Http\Controllers\Web\MonitoringProjectMeetingParticipantController::class, 'update'])->name('monitoring-project-meeting-participant/update');
    Route::get('/monitoring-project-meeting-participant/show/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingParticipantController::class, 'show'])->name('monitoring-project-meeting-participant/show');
    Route::post('/monitoring-project-meeting-participant/delete/{id}', [App\Http\Controllers\Web\MonitoringProjectMeetingParticipantController::class, 'destroy'])->name('monitoring-project-meeting-participant/delete');

    //FileExtension
    Route::post('/file-extension/getData', [App\Http\Controllers\Web\FileExtensionController::class, 'getData'])->name('file-extension/getData');

    //Document Type
    Route::get('/document-type', [App\Http\Controllers\Web\DocumentTypeController::class, 'index'])->name('document-type');
    Route::post('/document-type/getData', [App\Http\Controllers\Web\DocumentTypeController::class, 'getData'])->name('document-type/getData');
    Route::get('/document-type/getDataActive', [App\Http\Controllers\Web\DocumentTypeController::class, 'getDataActive'])->name('document-type/getDataActive');
    Route::post('/document-type/store', [App\Http\Controllers\Web\DocumentTypeController::class, 'store'])->name('document-type/store');
    Route::post('/document-type/update', [App\Http\Controllers\Web\DocumentTypeController::class, 'update'])->name('document-type/update');
    Route::get('/document-type/{id}', [App\Http\Controllers\Web\DocumentTypeController::class, 'show'])->name('document-type');
    Route::post('/document-type/delete/{id}', [App\Http\Controllers\Web\DocumentTypeController::class, 'destroy'])->name('document-type/delete');

    //Folder
    Route::post('/folder/getData', [App\Http\Controllers\Web\FolderController::class, 'getData'])->name('folder/getData');
    Route::post('/folder/getDataChild', [App\Http\Controllers\Web\FolderController::class, 'getDataChild'])->name('folder/getDataChild');
    Route::post('/folder/getDataRecycle', [App\Http\Controllers\Web\FolderController::class, 'getDataRecycle'])->name('folder/getDataRecycle');
    Route::post('/folder/store', [App\Http\Controllers\Web\FolderController::class, 'store'])->name('folder/store');
    Route::post('/folder/update', [App\Http\Controllers\Web\FolderController::class, 'update'])->name('folder/update');
    Route::get('/folder/{id}', [App\Http\Controllers\Web\FolderController::class, 'show'])->name('folder/show');
    Route::post('/folder/delete/{id}', [App\Http\Controllers\Web\FolderController::class, 'destroy'])->name('folder/delete');
    Route::post('/folder/restore/{id}', [App\Http\Controllers\Web\FolderController::class, 'restore'])->name('folder/restore');
    Route::get('/folder/export/document', [App\Http\Controllers\Web\FolderController::class, 'export'])->name('folder/export');

    //Document
    Route::get('/document', [App\Http\Controllers\Web\DocumentController::class, 'index'])->name('document');
    Route::get('/document/child/{id}', [App\Http\Controllers\Web\DocumentController::class, 'child'])->name('document/child');
    Route::post('/document/getData', [App\Http\Controllers\Web\DocumentController::class, 'getData'])->name('document/getData');
    Route::post('/document/getDataRecycle', [App\Http\Controllers\Web\DocumentController::class, 'getDataRecycle'])->name('document/getDataRecycle');
    Route::post('/document/store', [App\Http\Controllers\Web\DocumentController::class, 'store'])->name('document/store');
    Route::post('/document/update', [App\Http\Controllers\Web\DocumentController::class, 'update'])->name('document/update');
    Route::post('/document/archive', [App\Http\Controllers\Web\DocumentController::class, 'archive'])->name('document/archive');
    Route::get('/document/{id}', [App\Http\Controllers\Web\DocumentController::class, 'show'])->name('document/show');
    Route::get('/document/download/{id}', [App\Http\Controllers\Web\DocumentController::class, 'download'])->name('document/download');
    Route::get('/document/stream/{id}', [App\Http\Controllers\Web\DocumentController::class, 'stream'])->name('document/stream');
    Route::post('/document/delete/{id}', [App\Http\Controllers\Web\DocumentController::class, 'destroy'])->name('document/delete');
    Route::post('/document/restore/{id}', [App\Http\Controllers\Web\DocumentController::class, 'restore'])->name('document/restore');
    Route::get('/document/child/{id}', [App\Http\Controllers\Web\DocumentController::class, 'child'])->name('document/child');
    Route::get('/document/export/{id}', [App\Http\Controllers\Web\DocumentController::class, 'export'])->name('document/export');

    //Recycle Bin
    Route::get('/recycle', [App\Http\Controllers\Web\RecycleController::class, 'index'])->name('recycle');

    //Document Archive
    Route::get('/document-archive', [App\Http\Controllers\Web\DocumentArchiveController::class, 'index'])->name('document-archive');
    Route::post('/document-archive/getData', [App\Http\Controllers\Web\DocumentArchiveController::class, 'getData'])->name('document-archive/getData');
    Route::get('/document-archive/download/{id}', [App\Http\Controllers\Web\DocumentArchiveController::class, 'download'])->name('document-archive/download');
    Route::get('/document-archive/stream/{id}', [App\Http\Controllers\Web\DocumentArchiveController::class, 'stream'])->name('document-archive/stream');

    //Schedule Email
    Route::get('/schedule-mail', [App\Http\Controllers\Web\ScheduleEmailController::class, 'index'])->name('schedule-mail');
    Route::post('/schedule-mail/getData', [App\Http\Controllers\Web\ScheduleEmailController::class, 'getData'])->name('schedule-mail/getData');
    Route::get('/schedule-mail/create', [App\Http\Controllers\Web\ScheduleEmailController::class, 'create'])->name('schedule-mail/create');
    Route::post('/schedule-mail/store', [App\Http\Controllers\Web\ScheduleEmailController::class, 'store'])->name('schedule-mail/store');
    Route::get('/schedule-mail/detail/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'detail'])->name('schedule-mail/detail');
    Route::get('/schedule-mail/edit/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'edit'])->name('schedule-mail/edit');
    Route::post('/schedule-mail/update', [App\Http\Controllers\Web\ScheduleEmailController::class, 'update'])->name('schedule-mail/update');
    Route::get('/schedule-mail/show/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'show'])->name('schedule-mail/show');
    Route::post('/schedule-mail/delete/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'destroy'])->name('schedule-mail/delete');
    Route::get('/schedule-mail/download/attachment/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'downloadAttachment'])->name('schedule-mail/download/attachment');
    Route::get('/schedule-mail/send/{id}', [App\Http\Controllers\Web\ScheduleEmailController::class, 'send'])->name('schedule-mail/send');
    Route::post('/schedule-mail/total/client', [App\Http\Controllers\Web\ScheduleEmailController::class, 'totalClient'])->name('schedule-mail/total/client');

    //Profile
    Route::get('/profile', [App\Http\Controllers\Web\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/show/{id}', [App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile/show');
    Route::post('/profile/update', [App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile/update');
    Route::post('/profile/password', [App\Http\Controllers\Web\ProfileController::class, 'changePassword'])->name('profile/password');
});
