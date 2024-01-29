@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">


            <div class="col-xl-12">
                <!-- div -->
                <div class="card" id="tabs-style4">
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            تفاصيل الفاتورة
                        </div>

                        <div class="text-wrap">
                            <div class="example">
                                <div class="d-md-flex">
                                    <div class="">
                                        <div class="panel panel-primary tabs-style-4">
                                            <div class="tab-menu-heading">
                                                <div class="tabs-menu ">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs ml-3">
                                                        <li class=""><a href="#tab21" class="active"
                                                                data-toggle="tab"><i class="fa fa-laptop"></i> تفاصيل
                                                                الفاتوره
                                                            </a></li>
                                                        <li><a href="#tab22" data-toggle="tab"><i class="fa fa-cube"></i>
                                                                حالة الدفع</a></li>
                                                        <li><a href="#tab23" data-toggle="tab"><i class="fa fa-cogs"></i>
                                                                المرفقات</a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        use App\Models\invoices_details;
                                        // $invoice = invoices_details::where('id_Invoice', $id)->first();
                                        // $invoice = invoices_details::find($id);
                                    @endphp

                                    <div class="tabs-style-4 ">
                                        <div class="panel-body tabs-menu-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab21">
                                                    <div class="table-responsive mt-15">
                                                        <table class="table table-striped" style="text-align:center">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">رقم الفاتوره</th>
                                                                    <td>{{ $invoice->invoice_number }}</td>
                                                                    <th scope="row">تاريخ الاصدار</th>
                                                                    <td>{{ $invoice->invoice_Date }}</td>
                                                                    <th scope="row">تاريخ الاستحقاق</th>
                                                                    <td>{{ $invoice->Due_date }}</td>
                                                                    <th scope="row">القسم</th>
                                                                    <td>{{ $invoice->Section->section_name }}</td>
                                                                    <th scope="row">ملاحظات</th>
                                                                    <td>{{ $invoice->note }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">المنتج</th>
                                                                    <td>{{ $invoice->product }}</td>
                                                                    <th scope="row">مبلغ التحصيل</th>
                                                                    <td>{{ $invoice->Amount_collection }}</td>
                                                                    <th scope="row">مبلغ العموله</th>
                                                                    <td>{{ $invoice->Amount_Commission }}</td>
                                                                    <th scope="row">الخصم</th>
                                                                    <td>{{ $invoice->Discount }}</td>

                                                                </tr>
                                                                <tr>
                                                                    {{-- <td>{{ $invoice->Status }}</td> --}}

                                                                    <th scope="row">نسبة الضريبه</th>
                                                                    <td>{{ $invoice->Rate_VAT }}</td>
                                                                    <th scope="row">قيمة الضريبة</th>
                                                                    <td>{{ $invoice->Value_VAT }}</td>
                                                                    <th scope="row"> الاجمالي</th>
                                                                    <td>{{ $invoice->Total }}</td>
                                                                    <th scope="row">الحالة</th>
                                                                    <td>
                                                                        @if ($invoice->Value_Status == 1)
                                                                            <span
                                                                                class="badge badge-bill  badge-success">{{ $invoice->Status }}</span>
                                                                        @elseif ($invoice->Value_Status == 2)
                                                                            <span
                                                                                class="badge badge-bill  badge-danger">{{ $invoice->Status }}</span>
                                                                        @else
                                                                            <span
                                                                                class="badge badge-bill  badge-warning">{{ $invoice->Status }}</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tab22">
                                                    <div class="table-responsive mt-15">
                                                        <table class="table center-aligned-table mb-0 table-hover"
                                                            style="text-align:center">
                                                            <thead>
                                                                <tr class="text-dark">
                                                                    <th>#</th>
                                                                    <th>رقم الفاتورة</th>
                                                                    <th>نوع المنتج</th>
                                                                    <th>القسم</th>
                                                                    <th>حالة الدفع</th>
                                                                    <th>تاريخ الدفع </th>
                                                                    <th>ملاحظات</th>
                                                                    <th>تاريخ الاضافة </th>
                                                                    <th>المستخدم</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($details as $x)
                                                                    <?php $i++; ?>
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $x->invoice_number }}</td>
                                                                        <td>{{ $x->product }}</td>
                                                                        <td>{{ $invoice->Section->section_name }}</td>
                                                                        @if ($x->Value_Status == 1)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-success">{{ $x->Status }}</span>
                                                                            </td>
                                                                        @elseif($x->Value_Status == 2)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-danger">{{ $x->Status }}</span>
                                                                            </td>
                                                                        @else
                                                                            <td><span
                                                                                    class="badge badge-pill badge-warning">{{ $x->Status }}</span>
                                                                            </td>
                                                                        @endif
                                                                        <td>{{ $x->Payment_Date }}</td>
                                                                        <td>{{ $x->note }}</td>
                                                                        <td>{{ $x->created_at }}</td>
                                                                        <td>{{ $x->user }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab23">
                                                    <!--المرفقات-->
                                                    <div class="card card-statistics">
                                                        @if ($errors->has('file'))
                                                            <span class="text-danger">{{ $errors->first('file') }}</span>
                                                        @endif

                                                        {{-- <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                            <h5 class="card-title">اضافة مرفقات</h5>
                                                            <form action="{{ route('invoicesAttachement.store') }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="custom-file">

                                                                    <input type="text" id="customFile"
                                                                        name="invoice_nunmber"
                                                                        value="{{ $invoice->invoice_number }}">

                                                                    <input type="text" id="invoice_id"
                                                                        name="invoice_id" value="{{ $invoice->id }}">

                                                                    <input type="file" class="custom-file-input"
                                                                        id="customFile" name="file_name" required
                                                                        accept=".pdf,.jpeg,.jpg,.png">

                                                                    <label class="custom-file-label" for="customFile">حدد
                                                                        المرفق</label>

                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="uploadedFile">تاكيد</button>

                                                        </div> --}}

                                                        {{-- @can('اضافة مرفق') --}}
                                                        <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                            <h5 class="card-title">اضافة مرفقات</h5>
                                                            <form method="post"
                                                                action="{{ route('invoicesAttachement.store') }}"
                                                                enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="customFile" name="file_name" required>
                                                                    <input type="hidden" id="customFile"
                                                                        name="invoice_number"
                                                                        value="{{ $invoice->invoice_number }}">
                                                                    <input type="hidden" id="invoice_id"
                                                                        name="invoice_id" value="{{ $invoice->id }}">
                                                                    <label class="custom-file-label" for="customFile">حدد
                                                                        المرفق</label>
                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="uploadedFile">تاكيد</button>
                                                            </form>
                                                        </div>
                                                        {{-- @endcan  --}}
                                                        <br>

                                                        <div class="table-responsive mt-15">
                                                            <table
                                                                class="table center-aligned-table mb-0 table table-hover"
                                                                style="text-align:center">
                                                                <thead>
                                                                    <tr class="text-dark">
                                                                        <th scope="col">م</th>
                                                                        <th scope="col">اسم الملف</th>
                                                                        <th scope="col">قام بالاضافة</th>
                                                                        <th scope="col">تاريخ الاضافة</th>
                                                                        <th scope="col">العمليات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 0; ?>
                                                                    @foreach ($attachments as $attachment)
                                                                        <?php $i++; ?>
                                                                        <tr>
                                                                            <td>{{ $i }}</td>
                                                                            <td>{{ $attachment->file_name }}</td>
                                                                            <td>{{ $attachment->Created_by }}</td>
                                                                            <td>{{ $attachment->created_at }}</td>
                                                                            <td colspan="2">

                                                                                <a class="btn btn-outline-success btn-sm"
                                                                                    href="{{ url('viewAttachment') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                    role="button"><i
                                                                                        class="fas fa-eye"></i>&nbsp;
                                                                                    عرض</a>

                                                                                <a class="btn btn-outline-info btn-sm"
                                                                                    href="{{ url('downloadAttachment') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                    role="button"><i
                                                                                        class="fas fa-download"></i>&nbsp;
                                                                                    تحميل</a>

                                                                                {{-- @can('حذف المرفق') --}}
                                                                                <button
                                                                                    class="btn btn-outline-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-file_name="{{ $attachment->file_name }}"
                                                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                    data-id_file="{{ $attachment->id }}"
                                                                                    data-target="#delete_file">حذف</button>
                                                                                {{-- @endcan --}}

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- delete modal --}}
                            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('delete_file') }}" method="post">

                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <p class="text-center">
                                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                                </p>

                                                <input type="hidden" name="id_file" id="id_file" value="">
                                                <input type="hidden" name="file_name" id="file_name" value="">
                                                <input type="hidden" name="invoice_number" id="invoice_number"
                                                    value="">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">الغاء</button>
                                                <button type="submit" class="btn btn-danger">تاكيد</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- /row -->
                        </div>
                        <!-- Container closed -->
                    </div>
                    <!-- main-content closed -->
                @endsection
                @section('js')
                    <!--Internal  Datepicker js -->
                    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
                    <!-- Internal Select2 js-->
                    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
                    <!-- Internal Jquery.mCustomScrollbar js-->
                    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
                    <!-- Internal Input tags js-->
                    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
                    <!--- Tabs JS-->
                    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
                    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
                    <!--Internal  Clipboard js-->
                    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
                    <!-- Internal Prism js-->
                    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>





                    {{-- view button --}}
                    <script>
                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                            var fileName = $(this).val().split("\\").pop();
                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                    </script>
                    {{-- delete button --}}
                    <script>
                        $('#delete_file').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget)
                            var id_file = button.data('id_file')
                            var file_name = button.data('file_name')
                            var invoice_number = button.data('invoice_number')
                            var modal = $(this)

                            modal.find('.modal-body #id_file').val(id_file);
                            modal.find('.modal-body #file_name').val(file_name);
                            modal.find('.modal-body #invoice_number').val(invoice_number);
                        })
                    </script>
                @endsection
