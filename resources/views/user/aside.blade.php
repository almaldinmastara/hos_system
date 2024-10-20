<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#">
            <img src="./assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">نظام احصائيات</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <!-- Lab Link -->
            <li class="nav-item">
                <a href="{{route('lab') }}" class="nav-link d-flex align-items-center btn btn-success mb-2">
                    <div class="icon icon-shape icon-sm bg-white text-center me-2 d-flex align-items-center justify-content-center rounded-circle">
                        <i class="material-icons opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">المعمل</span>
                </a>
            </li>

            <!-- Accommodation Link -->
            <li class="nav-item">
                <a href="{{url('ewaa')}}" class="nav-link d-flex align-items-center btn btn-success mb-2">
                    <div class="icon icon-shape icon-sm bg-white text-center me-2 d-flex align-items-center justify-content-center rounded-circle">
                        <i class="material-icons opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">الايواء</span>
                </a>
            </li>

            <!-- Clinics Link -->
            <li class="nav-item">
                <a href="{{ route('eyadat') }}" class="nav-link d-flex align-items-center btn btn-success mb-2">
                    <div class="icon icon-shape icon-sm bg-white text-center me-2 d-flex align-items-center justify-content-center rounded-circle">
                        <i class="material-icons opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">العيادات</span>
                </a>
            </li>


            <!-- Operations Link -->
            <li class="nav-item">
                <a href="{{ route('amlyat') }}" class="nav-link d-flex align-items-center btn btn-success mb-2">
                    <div class="icon icon-shape icon-sm bg-white text-center me-2 d-flex align-items-center justify-content-center rounded-circle">
                        <i class="material-icons opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">العمليات</span>
                </a>
            </li>

        </ul>
    </div>

</aside>
