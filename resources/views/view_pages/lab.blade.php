<!DOCTYPE html>
<html lang="ar">

<head>
@include('view_pages.css')
</head>
<body>
    <div class="container mt-5">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row justify-content-center">

            <!-- العمود الذي يحتوي على الرقم -->
            <div class="col-md-2">
                <div class="number-box">
                    @if(isset($results) && $results->count() > 0)
                    <p> النتائج: {{ $results->count() }}</p>
                @else
                    <p>لا توجد بيانات</p>
                @endif

                </div>
            </div>

           <!-- العمود الذي يحتوي على تاريخ البداية، تاريخ النهاية، و البحث -->
           <div class="col-md-10">
            <form action="{{ route('search.route') }}" method="GET">
                <div class="row mb-3">
                    <!-- حقل البحث -->
                    <div class="col-md-4">
                        <div class="rounded-box">
                            <label for="search">ابحث هنا</label>
                            <input type="text" name="search" id="search" class="form-control search-box" placeholder="ادخل ما تريد البحث عنه">
                        </div>
                    </div>
               <!-- تاريخ النهاية -->
               <div class="col-md-4">
                <div class="rounded-box">
                    <label for="end_date">تاريخ النهاية</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>
            </div>
                    <!-- تاريخ البداية -->
                    <div class="col-md-4">
                        <div class="rounded-box">
                            <label for="start_date">تاريخ البداية</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                    </div>


                </div>

                <!-- أزرار البحث والتنزيل -->
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('download.route', ['start_date' => request()->start_date, 'end_date' => request()->end_date, 'search' => request()->search]) }}" class="btn btn-success">تنزيل</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="results-box">
                            <h5>البيانات التي يبحث عنها:</h5>
                            <table class="table table-bordered table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>القسم</th>
                                        <th>التاريخ</th>
                                        <th>التحليل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results) && $results->count() > 0)
                                        @foreach($results as $result)
                                            <tr>
                                                <td>{{ $result->name }}</td>
                                                <td>{{ $result->department }}</td>
                                                <td>{{ $result->date }}</td>
                                                <td>{{ $result->analysis }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">لا توجد بيانات لعرضها.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ربط Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
