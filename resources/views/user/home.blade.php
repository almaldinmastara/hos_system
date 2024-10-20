<!DOCTYPE html>
<html lang="ar">

<head>
    @include('user.css')
    <!-- إضافة روابط Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة روابط Bootstrap JS و jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

    <!-- Aside -->
    @include('user.aside')
    <!-- End Aside -->

    <main class="main-content border-radius-lg">
        <!-- Navbar -->
        @include('user.navbar')
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="container-fluid py-4">
            @include('user.body')

            <!-- Export and Upload Excel Forms -->
            <div class="container mt-5">
                <h2 class="mb-4 text-center">تصدير البيانات ورفع ملفات </h2>
                <div class="row justify-content-center">
                    <!-- Export Data Form -->
                    <div class="col-md-6 custom-container">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="upload_type">اختر القسم:</label>
                                <select name="upload_type" id="upload_type" class="form-control" required>
                                    <option value="">اختار </option>
                                    <option value="clinic">العيادات</option>
                                    <option value="lab">المختبرات</option>
                                    <option value="Awya">الإيواء</option>
                                    <option value="surgery">العمليات</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="excel_file">رفع ملف Excel:</label>
                                <input type="file" name="file" id="excel_file" class="form-control" accept=".xls, .xlsx" required>
                            </div>

                            <button type="submit" class="btn btn-success d-block mx-auto">رفع الملف</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Export and Upload Excel Forms -->

        </div>
        <!-- End Main Content -->
    </main>

</body>

</html>
