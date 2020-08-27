<div class="modal fade bd-servertime" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:black;">{{ __('Timezone') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.servertime') }}" method="POST" target="_top">
                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="form-group">
                        @php($timezone = \App\Models\Setting::getValue('timezone', null))
                        <select class="form-control" id="servertime" name="servertime">
                            <option value="Pacific/Midway"{{ $timezone == 'Pacific/Midway' ? ' selected' : '' }}>(GMT-11:00) Midway Island, Samoa</option>
                            <option value="America/Adak"{{ $timezone == 'America/Adak' ? ' selected' : '' }}>(GMT-10:00) Hawaii-Aleutian</option>
                            <option value="Etc/GMT+10"{{ $timezone == 'Etc/GMT+10"' ? ' selected' : '' }}>(GMT-10:00) Hawaii</option>
                            <option value="Pacific/Marquesas"{{ $timezone == 'Pacific/Marquesas' ? ' selected' : '' }}>(GMT-09:30) Marquesas Islands</option>
                            <option value="Pacific/Gambier"{{ $timezone == 'Pacific/Gambier' ? ' selected' : '' }}>(GMT-09:00) Gambier Islands</option>
                            <option value="America/Anchorage"{{ $timezone == 'America/Anchorage' ? ' selected' : '' }}>(GMT-09:00) Alaska</option>
                            <option value="America/Ensenada"{{ $timezone == 'America/Ensenada' ? ' selected' : '' }}>(GMT-08:00) Tijuana, Baja California</option>
                            <option value="Etc/GMT+8"{{ $timezone == 'Etc/GMT+8' ? ' selected' : '' }}>(GMT-08:00) Pitcairn Islands</option>
                            <option value="America/Los_Angeles"{{ $timezone == 'America/Los_Angeles' ? ' selected' : '' }}>(GMT-08:00) Pacific Time (US & Canada)</option>
                            <option value="America/Denver"{{ $timezone == 'America/Denver' ? ' selected' : '' }}>(GMT-07:00) Mountain Time (US & Canada)</option>
                            <option value="America/Chihuahua"{{ $timezone == 'America/Chihuahua' ? ' selected' : '' }}>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                            <option value="America/Dawson_Creek"{{ $timezone == 'America/Dawson_Creek' ? ' selected' : '' }}>(GMT-07:00) Arizona</option>
                            <option value="America/Belize"{{ $timezone == 'America/Belize' ? ' selected' : '' }}>(GMT-06:00) Saskatchewan, Central America</option>
                            <option value="America/Cancun"{{ $timezone == 'America/Cancun' ? ' selected' : '' }}>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                            <option value="Chile/EasterIsland"{{ $timezone == 'Chile/EasterIsland' ? ' selected' : '' }}>(GMT-06:00) Easter Island</option>
                            <option value="America/Chicago"{{ $timezone == 'America/Chicago' ? ' selected' : '' }}>(GMT-06:00) Central Time (US & Canada)</option>
                            <option value="America/New_York"{{ $timezone == 'America/New_York' ? ' selected' : '' }}>(GMT-05:00) Eastern Time (US & Canada)</option>
                            <option value="America/Havana"{{ $timezone == 'America/Havana' ? ' selected' : '' }}>(GMT-05:00) Cuba</option>
                            <option value="America/Bogota"{{ $timezone == 'America/Bogota' ? ' selected' : '' }}>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                            <option value="America/Caracas"{{ $timezone == 'America/Caracas' ? ' selected' : '' }}>(GMT-04:30) Caracas</option>
                            <option value="America/Santiago"{{ $timezone == 'America/Santiago' ? ' selected' : '' }}>(GMT-04:00) Santiago</option>
                            <option value="America/La_Paz"{{ $timezone == 'America/La_Paz' ? ' selected' : '' }}>(GMT-04:00) La Paz</option>
                            <option value="Atlantic/Stanley"{{ $timezone == 'Atlantic/Stanley' ? ' selected' : '' }}>(GMT-04:00) Faukland Islands</option>
                            <option value="America/Campo_Grande"{{ $timezone == 'America/Campo_Grande' ? ' selected' : '' }}>(GMT-04:00) Brazil</option>
                            <option value="America/Goose_Bay"{{ $timezone == 'America/Goose_Bay' ? ' selected' : '' }}>(GMT-04:00) Atlantic Time (Goose Bay)</option>
                            <option value="America/Glace_Bay"{{ $timezone == 'America/Glace_Bay' ? ' selected' : '' }}>(GMT-04:00) Atlantic Time (Canada)</option>
                            <option value="America/St_Johns"{{ $timezone == 'America/St_Johns' ? ' selected' : '' }}>(GMT-03:30) Newfoundland</option>
                            <option value="America/Araguaina"{{ $timezone == 'America/Araguaina' ? ' selected' : '' }}>(GMT-03:00) UTC-3</option>
                            <option value="America/Montevideo"{{ $timezone == 'America/Montevideo' ? ' selected' : '' }}>(GMT-03:00) Montevideo</option>
                            <option value="America/Miquelon"{{ $timezone == 'America/Miquelon' ? ' selected' : '' }}>(GMT-03:00) Miquelon, St. Pierre</option>
                            <option value="America/Godthab"{{ $timezone == 'America/Godthab' ? ' selected' : '' }}>(GMT-03:00) Greenland</option>
                            <option value="America/Argentina/Buenos_Aires"{{ $timezone == 'America/Argentina/Buenos_Aires' ? ' selected' : '' }}>(GMT-03:00) Buenos Aires</option>
                            <option value="America/Sao_Paulo"{{ $timezone == 'America/Sao_Paulo' ? ' selected' : '' }}>(GMT-03:00) Brasilia</option>
                            <option value="America/Noronha"{{ $timezone == 'America/Noronha' ? ' selected' : '' }}>(GMT-02:00) Mid-Atlantic</option>
                            <option value="Atlantic/Cape_Verde"{{ $timezone == 'Atlantic/Cape_Verde' ? ' selected' : '' }}>(GMT-01:00) Cape Verde Is.</option>
                            <option value="Atlantic/Azores"{{ $timezone == 'Atlantic/Azores' ? ' selected' : '' }}>(GMT-01:00) Azores</option>
                            <option value="Europe/Belfast"{{ $timezone == 'Europe/Belfast' ? ' selected' : '' }}>(GMT) Greenwich Mean Time : Belfast</option>
                            <option value="Europe/Dublin"{{ $timezone == 'Europe/Dublin' || $timezone == null ? ' selected' : '' }}>(GMT) Greenwich Mean Time : Dublin</option>
                            <option value="Europe/Lisbon"{{ $timezone == 'Europe/Lisbon' ? ' selected' : '' }}>(GMT) Greenwich Mean Time : Lisbon</option>
                            <option value="Europe/London"{{ $timezone == 'Europe/London' ? ' selected' : '' }}>(GMT) Greenwich Mean Time : London</option>
                            <option value="Africa/Abidjan"{{ $timezone == 'Africa/Abidjan' ? ' selected' : '' }}>(GMT) Monrovia, Reykjavik</option>
                            <option value="Europe/Amsterdam"{{ $timezone == 'Europe/Amsterdam' ? ' selected' : '' }}>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                            <option value="Europe/Belgrade"{{ $timezone == 'Europe/Belgrade' ? ' selected' : '' }}>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                            <option value="Europe/Brussels"{{ $timezone == 'Europe/Brussels' ? ' selected' : '' }}>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                            <option value="Africa/Algiers"{{ $timezone == 'Africa/Algiers' ? ' selected' : '' }}>(GMT+01:00) West Central Africa</option>
                            <option value="Africa/Windhoek"{{ $timezone == 'Africa/Windhoek' ? ' selected' : '' }}>(GMT+01:00) Windhoek</option>
                            <option value="Asia/Beirut"{{ $timezone == 'Asia/Beirut' ? ' selected' : '' }}>(GMT+02:00) Beirut</option>
                            <option value="Africa/Cairo"{{ $timezone == 'Africa/Cairo' ? ' selected' : '' }}>(GMT+02:00) Cairo</option>
                            <option value="Asia/Gaza"{{ $timezone == 'Asia/Gaza' ? ' selected' : '' }}>(GMT+02:00) Gaza</option>
                            <option value="Africa/Blantyre"{{ $timezone == 'Africa/Blantyre' ? ' selected' : '' }}>(GMT+02:00) Harare, Pretoria</option>
                            <option value="Asia/Jerusalem"{{ $timezone == 'Asia/Jerusalem' ? ' selected' : '' }}>(GMT+02:00) Jerusalem</option>
                            <option value="Europe/Minsk"{{ $timezone == 'Europe/Minsk' ? ' selected' : '' }}>(GMT+02:00) Minsk</option>
                            <option value="Asia/Damascus"{{ $timezone == 'Asia/Damascus' ? ' selected' : '' }}>(GMT+02:00) Syria</option>
                            <option value="Europe/Moscow"{{ $timezone == 'Europe/Moscow' ? ' selected' : '' }}>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                            <option value="Africa/Addis_Ababa"{{ $timezone == 'Africa/Addis_Ababa' ? ' selected' : '' }}>(GMT+03:00) Nairobi</option>
                            <option value="Asia/Tehran"{{ $timezone == 'Asia/Tehran' ? ' selected' : '' }}>(GMT+03:30) Tehran</option>
                            <option value="Asia/Dubai"{{ $timezone == 'Asia/Dubai' ? ' selected' : '' }}>(GMT+04:00) Abu Dhabi, Muscat</option>
                            <option value="Asia/Yerevan"{{ $timezone == 'Asia/Yerevan' ? ' selected' : '' }}>(GMT+04:00) Yerevan</option>
                            <option value="Asia/Kabul"{{ $timezone == 'Asia/Kabul' ? ' selected' : '' }}>(GMT+04:30) Kabul</option>
                            <option value="Asia/Yekaterinburg"{{ $timezone == 'Asia/Yekaterinburg' ? ' selected' : '' }}>(GMT+05:00) Ekaterinburg</option>
                            <option value="Asia/Tashkent"{{ $timezone == 'Asia/Tashkent' ? ' selected' : '' }}>(GMT+05:00) Tashkent</option>
                            <option value="Asia/Kolkata"{{ $timezone == 'Asia/Kolkata' ? ' selected' : '' }}>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                            <option value="Asia/Katmandu"{{ $timezone == 'Asia/Katmandu' ? ' selected' : '' }}>(GMT+05:45) Kathmandu</option>
                            <option value="Asia/Dhaka"{{ $timezone == 'Asia/Dhaka' ? ' selected' : '' }}>(GMT+06:00) Astana, Dhaka</option>
                            <option value="Asia/Novosibirsk"{{ $timezone == 'Asia/Novosibirsk' ? ' selected' : '' }}>(GMT+06:00) Novosibirsk</option>
                            <option value="Asia/Rangoon"{{ $timezone == 'Asia/Rangoon' ? ' selected' : '' }}>(GMT+06:30) Yangon (Rangoon)</option>
                            <option value="Asia/Bangkok"{{ $timezone == 'sia/Bangkok' ? ' selected' : '' }}>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                            <option value="Asia/Krasnoyarsk"{{ $timezone == 'Asia/Krasnoyarsk' ? ' selected' : '' }}>(GMT+07:00) Krasnoyarsk</option>
                            <option value="Asia/Hong_Kong"{{ $timezone == 'Asia/Hong_Kong' ? ' selected' : '' }}>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                            <option value="Asia/Irkutsk"{{ $timezone == 'Asia/Irkutsk' ? ' selected' : '' }}>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                            <option value="Australia/Perth"{{ $timezone == 'Australia/Perth' ? ' selected' : '' }}>(GMT+08:00) Perth</option>
                            <option value="Australia/Eucla"{{ $timezone == 'Australia/Eucla' ? ' selected' : '' }}>(GMT+08:45) Eucla</option>
                            <option value="Asia/Tokyo"{{ $timezone == 'Asia/Tokyo' ? ' selected' : '' }}>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                            <option value="Asia/Seoul"{{ $timezone == 'Asia/Seoul' ? ' selected' : '' }}>(GMT+09:00) Seoul</option>
                            <option value="Asia/Yakutsk"{{ $timezone == 'Asia/Yakutsk' ? ' selected' : '' }}>(GMT+09:00) Yakutsk</option>
                            <option value="Australia/Adelaide"{{ $timezone == 'Australia/Adelaide' ? ' selected' : '' }}>(GMT+09:30) Adelaide</option>
                            <option value="Australia/Darwin"{{ $timezone == 'Australia/Darwin' ? ' selected' : '' }}>(GMT+09:30) Darwin</option>
                            <option value="Australia/Brisbane"{{ $timezone == 'Australia/Brisbane' ? ' selected' : '' }}>(GMT+10:00) Brisbane</option>
                            <option value="Australia/Hobart"{{ $timezone == 'Australia/Hobart' ? ' selected' : '' }}>(GMT+10:00) Hobart</option>
                            <option value="Asia/Vladivostok"{{ $timezone == 'Asia/Vladivostok' ? ' selected' : '' }}>(GMT+10:00) Vladivostok</option>
                            <option value="Australia/Lord_Howe"{{ $timezone == 'Australia/Lord_Howe' ? ' selected' : '' }}>(GMT+10:30) Lord Howe Island</option>
                            <option value="Etc/GMT-11"{{ $timezone == 'Etc/GMT-11' ? ' selected' : '' }}>(GMT+11:00) Solomon Is., New Caledonia</option>
                            <option value="Asia/Magadan"{{ $timezone == 'Asia/Magadan' ? ' selected' : '' }}>(GMT+11:00) Magadan</option>
                            <option value="Pacific/Norfolk"{{ $timezone == 'Pacific/Norfolk' ? ' selected' : '' }}>(GMT+11:30) Norfolk Island</option>
                            <option value="Asia/Anadyr"{{ $timezone == 'Asia/Anadyr' ? ' selected' : '' }}>(GMT+12:00) Anadyr, Kamchatka</option>
                            <option value="Pacific/Auckland"{{ $timezone == 'Pacific/Auckland' ? ' selected' : '' }}>(GMT+12:00) Auckland, Wellington</option>
                            <option value="Etc/GMT-12"{{ $timezone == 'Etc/GMT-12' ? ' selected' : '' }}>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                            <option value="Pacific/Chatham"{{ $timezone == 'Pacific/Chatham' ? ' selected' : '' }}>(GMT+12:45) Chatham Islands</option>
                            <option value="Pacific/Tongatapu"{{ $timezone == 'Pacific/Tongatapu' ? ' selected' : '' }}>(GMT+13:00) Nuku'alofa</option>
                            <option value="Pacific/Kiritimati"{{ $timezone == 'Pacific/Kiritimati' ? ' selected' : '' }}>(GMT+14:00) Kiritimati</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save_server_timezone') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>