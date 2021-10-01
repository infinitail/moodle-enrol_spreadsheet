<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'enrol_spreadsheet', language 'ja'.
 *
 * @package    enrol_spreadsheet
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'スプレッドシート登録';
$string['pluginname_desc'] = 'This plugin is developed for Spreadsheet enrolment';

$string['applychanges'] = 'Apply changes';
$string['spreadsheetfile'] = 'スプレッドシートファイル';
$string['spreadsheetfile_help'] = 'スプレッドシートファイルを選択してください';
$string['encoding'] = 'ファイルエンコーディング';
$string['enroltime'] = '受講登録日時';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['spreadsheet:manage'] = 'Manage user enrolments manually';
$string['spreadsheet:unenrol'] = 'Unenrol users from the course manually';
$string['mapping'] = 'Flat file role mapping';
$string['overrideotherenrolment'] = '他の受講登録を上書き';
$string['overrideotherenrolment_help'] = '他の登録方法で受講登録されたユーザを上書きする';
$string['retainremovedusers'] = 'スプレッドシートファイルから削除されたユーザを保持';
$string['retainremovedusers_help'] = 'スプレッドシート登録で受講登録されているユーザがリストに無い場合の振る舞いを設定します<br />
Yes - スプレッドシート登録で受講登録されているユーザをそのまま保持します<br />
NO - 現在、このコースにスプレッドシート登録で登録されていてリストにいないユーザは受講登録を解除され、コースでの活動履歴は消去されます';
$string['enableplugin'] = 'プラグインの有効化';
$string['updateenrolment'] = '受講登録の更新';

$string['headerrows'] = 'ヘッダ行数';
$string['headerrows_help'] = 'スプレッドシートファイルでヘッダとして無視する行数';
$string['idnumbercolumnposition'] = get_string('idnumber').'列の位置';
$string['idnumbercolumnposition_help'] = get_string('idnumber').'の記録されている列の位置を指定';
$string['dryrun'] = 'テスト';
$string['dryrunresult'] = 'テスト結果 - 影響を受けるユーザ: {$a}人';
$string['dryrunwarning'] = 'テスト結果を反映される場合は、更新ボタンをクリックしてください。';
$string['updatemessage'] = 'スプレッドシートの内容を登録しました。';
$string['ADD'] = 'ADD';
$string['DEL'] = 'DEL';
