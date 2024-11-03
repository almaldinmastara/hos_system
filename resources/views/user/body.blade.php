<div class="row">
    <div class="col-lg-5 col-sm-5">

        <!-- Card: Lab Tests -->
        <div class="card mb-2">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">المعمل</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">السنة الحالية</p>
                    <h4 class="mb-0">{{ $Year ?? 'لا توجد بيانات' }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-gradient-primary text-white" style="padding: 5px 10px; font-size: 0.9rem; font-weight: bold; border-radius: 8px;">
                        الشهر الحالي: {{ $Month ?? 'لا توجد بيانات' }}
                    </span>
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">{{ $Today ?? 'لا توجد بيانات' }}</span> اليوم
                    </p>
                </div>
            </div>
        </div>

        <!-- Card: Hospital Stays -->
        <div class="card mb-2">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">الايواء</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">السنة الحالية</p>
                    <h4 class="mb-0">{{ $aywa_y ?? 'لا توجد بيانات' }}</h4> <!-- يمكنك استخدام متغير آخر هنا -->
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-gradient-primary text-white" style="padding: 5px 10px; font-size: 0.9rem; font-weight: bold; border-radius: 8px;">
                        الشهر الحالي: {{ $aywa_m ?? 'لا توجد بيانات' }}
                    </span>
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">{{ $aywa_d ?? 'لا توجد بيانات' }}</span> اليوم
                    </p>
                </div>
            </div>
        </div>

        <!-- Card: Clinics -->
        <div class="card mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">العيادات</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">السنة الحالية </p>
                    <h4 class="mb-0"> {{ $Clinic_y ?? 'لا توجد بيانات' }}</h4> <!-- استخدم متغير خاص بالعيادات -->
                </div>
            </div>
            <hr class="horizontal my-0 dark">
            <div class="card-footer p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-gradient-primary text-white" style="padding: 5px 10px; font-size: 0.9rem; font-weight: bold; border-radius: 8px;">
                        الشهر الحالي: {{ $Clinic_m ?? 'لا توجد بيانات' }}
                    </span>
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder"> {{ $Clinic_d ?? 'لا توجد بيانات' }}</span> اليوم
                    </p>
                </div>
            </div>
        </div>

        <!-- Card: Surgeries -->
        <div class="card mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
                <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">العمليات</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize"> السنة الحالية</p>
                    <h4 class="mb-0"> {{ $Amlyat_y ?? 'لا توجد بيانات' }}</h4> <!-- استخدم متغير خاص بالعمليات -->
                </div>
            </div>
            <hr class="horizontal my-0 dark">
            <div class="card-footer p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-gradient-primary text-white" style="padding: 5px 10px; font-size: 0.9rem; font-weight: bold; border-radius: 8px;">
                        الشهر الحالي: {{ $Amlyat_m ?? 'لا توجد بيانات' }}
                    </span>
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">{{ $Amlyat_d ?? 'لا توجد بيانات' }}</span> اليوم
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Background Globe -->
    <div class="row">
        <div class="col-12">
            <div id="globe" class="position-absolute end-0 top-10 mt-sm-3 mt-7 me-lg-7">
                <canvas width="700" height="600" class="w-lg-100 h-lg-100 w-75 h-75 me-lg-0 me-n10 mt-lg-5"></canvas>
            </div>
        </div>
    </div>
</div>
