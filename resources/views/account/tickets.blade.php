@extends('layouts.account')
@section('title', __('Tickets'))

@section('content')
    @include('account.blocks.loader')
    @include('account.blocks.cp_navigation')

    <div class="cp_navi_main_wrapper inner_header_wrapper dashboard_header_middle float_left">
        <div class="container-fluid">
            @include('account.blocks.logo')
            @include('account.blocks.header')
            @include('account.blocks.top_header_right_wrapper')
            @include('account.blocks.menu')
        </div>
    </div>

    @include('account.blocks.dashboard_title')
    @include('account.blocks.sidebar')

    <!-- Main section Start -->
    <div class="l-main">
    @include('account.blocks.account_info')
        <!--  profile wrapper start -->
        <div class="last_transaction_wrapper float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper">
                        <h3>@yield('title')</h3>
                    </div>
                </div>
                <div class="crm_customer_table_main_wrapper float_left">
                    <div class="crm_ct_search_wrapper">
                        <div class="about_btn float_left">
                            <ul>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#myModal">new ticket</a>
                                </li>
                            </ul>
                        </div>
                        <div class="modal fade question_modal" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="sv_question_pop float_left">
                                                <h1>raise a ticket
                                                </h1>
                                                <div class="search_alert_box float_left">

                                                    <div class="change_field">

                                                        <input type="text" name="subject" placeholder="subject">
                                                    </div>
                                                    <div class="change_field">

                                                        <input type="text" name="phone" placeholder="contact no">
                                                    </div>
                                                    <div class="change_field">

                                                        <textarea class="form-control require" name="message" required="" rows="4" placeholder=" Message"></textarea>
                                                    </div>

                                                </div>
                                                <div class="question_sec float_left">
                                                    <div class="about_btn ques_Btn">
                                                        <ul>
                                                            <li>
                                                                <a href="#">send</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="cancel_wrapper">
                                                        <a href="#" class="" data-dismiss="modal">cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="myTable table datatables cs-table crm_customer_table_inner_Wrapper">
                            <thead>
                            <tr>
                                <th class="width_table1">ticket no</th>
                                <th class="width_table1">subject</th>
                                <th class="width_table1">status</th>
                                <th class="width_table1">date</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10001</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Hyip</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">03/07/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10002</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Withdraw Pending</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">04/07/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10022</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Hello</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">reOpen</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">12/07/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10041</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Request</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">reOpen</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">5/07/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10005</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Deposit</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">15/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10015</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Prueba</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">10/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10007</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Howejrpw</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">reOpen</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">15/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10088</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Test</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">5/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10081</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Template</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">6/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10082</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Hyip</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">9/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10045</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Transaction</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">reOpen</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">23/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10021</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">I didnt get payment</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">21/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10021</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">I didnt get payment</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">21/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10025</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> payment</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">21/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10004</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Lots of withdraw requests</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">reOpen</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">27/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10024</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Ticket 2016</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">27/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10002</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Ticket</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">1/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10006</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Teste</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">2/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10006</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Teste</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">2/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10011</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">test</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">2/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10006</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Deposit</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">3/08/2019</div>
                                </td>

                            </tr>
                            <tr class="background_white">

                                <td>
                                    <div class="media cs-media">

                                        <div class="media-body">
                                            <h5>#10009</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve"> Deposit</div>
                                </td>
                                <td>
                                    <div class="pretty p-svg p-curve">Open</div>
                                </td>

                                <td>
                                    <div class="pretty p-svg p-curve">3/08/2019</div>
                                </td>

                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--  profile wrapper end -->
        @include('account.blocks.footer')
    </div>
@endsection