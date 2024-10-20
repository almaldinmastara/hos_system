<!DOCTYPE html>
<html lang="ar">
<head>
@include('view_pages.css')
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- العمود الذي يحتوي على الرقم -->
            <div class="col-md-2">
                <div class="number-box">
                    العدد
                </div>
            </div>

            <!-- العمود الذي يحتوي على تاريخ البداية، تاريخ النهاية، و البحث -->
            <div class="col-md-10">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="rounded-box">
                            <label for="search">ابحث هنا</label>
                            <input type="text" id="search" class="form-control search-box">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="rounded-box">
                            <label for="start_date">تاريخ البداية</label>
                            <input type="date" id="start_date" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="rounded-box">
                            <label for="end_date">تاريخ النهاية</label>
                            <input type="date" id="end_date" class="form-control">
                        </div>
                    </div>
                </div>

        </div>

        <!-- منطقة عرض البيانات -->
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="results-box">
                            <h5>البيانات التي يبحث عنها:</h5>
                            <table class="table table-bordered table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>رقم</th>
                                        <th>اسم الحالة</th>
                                        <th>تاريخ البداية</th>
                                        <th>تاريخ النهاية</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>حالة 1</td>
                                        <td>2024-10-01</td>
                                        <td>2024-10-05</td>
                                        <td>ملاحظة 1</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>حالة 2</td>
                                        <td>2024-10-02</td>
                                        <td>2024-10-06</td>
                                        <td>ملاحظة 2</td>
                                    </tr>
                                    <!-- يمكنك إضافة المزيد من الصفوف هنا -->
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
