<?php
$currentUser = getCurrentUserInfo();
$menu = __('menu');
?>
<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg px-lg-0 px-0 py-0">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link nav-icon-hover sidebartoggler nav-icon-hover " id="headerCollapse"
                        href="javascript:void(0)">
                        <iconify-icon icon="solar:list-bold-duotone" class="fs-7"></iconify-icon>
                    </a>
                </li>
            </ul>


            <div class="d-block d-lg-none">
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/" class="text-nowrap logo-img">
                        <span class="">
                            {{-- <img src="{{ asset('/img-system/system/logo.png') }}" class="logo-horizontal ps-2"
                                alt="homepage"> --}}
                        </span>
                    </a>
                </div>
            </div>
            <aside class="left-sidebar with-horizontal">
                <div>
                    <nav class="sidebar-nav scroll-sidebar container-fluid">
                        <ul id="sidebarnav">
                            @if (is_array($menu) && count($menu))
                                @foreach ($menu as $key => $value)
                                    <li class="sidebar-item">
                                        <a class="sidebar-link {{ isset($value['items']) && is_array($value['items']) && count($value['items']) ? 'has-arrow' : '' }}"
                                            href="{{ $value['url'] }}" aria-expanded="false">
                                            @if (!empty($value['icon']))
                                                <span class="d-flex"><iconify-icon icon="{{ $value['icon'] }}"
                                                        class="fs-6"></iconify-icon></span>
                                            @endif
                                            <span class="hide-menu">{{ $value['name'] }}</span>
                                        </a>
                                        @if (isset($value['items']) && is_array($value['items']) && count($value['items']))
                                            <ul aria-expanded="false" class="collapse first-level">
                                                @foreach ($value['items'] as $keyItem => $valueItem)
                                                    <li class="sidebar-item">
                                                        <a href="{{ $valueItem['url'] }}"
                                                            class="sidebar-link {{ isset($valueItem['items']) && is_array($valueItem['items']) && count($valueItem['items']) ? 'has-arrow' : 'sublink' }}">
                                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                                <i class="sidebar-icon"></i>
                                                            </div>
                                                            <span class="hide-menu">{{ $valueItem['name'] }}</span>
                                                        </a>
                                                        @if (isset($valueItem['items']) && is_array($valueItem['items']) && count($valueItem['items']))
                                                            <ul aria-expanded="false" class="collapse second-level">
                                                                @foreach ($valueItem['items'] as $keyItemChild => $valueItemChild)
                                                                    <li class="sidebar-item">
                                                                        <a href="{{ $valueItemChild['url'] }}"
                                                                            class="sidebar-link sublink">
                                                                            <div
                                                                                class="round-16 d-flex align-items-center justify-content-center">
                                                                                <i class="sidebar-icon"></i>
                                                                            </div><span
                                                                                class="hide-menu">{{ $valueItemChild['name'] }}</span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                </div>
            </aside>
            <a class="navbar-toggler nav-icon-hover p-0 border-0 text-white" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <div class="d-flex align-items-center justify-content-between  py-2">
                    <ul class="navbar-nav flex-row d-flex d-lg-none">

                        <li class="nav-item dropdown mega-dropdown">
                            <a class="nav-link " id="drop2" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="d-lg-flex d-none">Mega</span>
                                <iconify-icon icon="solar:alt-arrow-down-outline"
                                    class=" ps-1 fs-4 d-lg-flex d-none"></iconify-icon>
                                <span class="d-lg-none d-flex">
                                    <iconify-icon icon="solar:code-scan-line-duotone"></iconify-icon>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="mega-dropdown-menu row">
                                    <div class="col-lg-3 col-xl-2 mb-4">
                                        <h4 class="mb-3 fs-5 ">Carousel</h4>
                                        <!-- CAROUSEL -->
                                        <div id="carouselExampleControls" class="carousel slide carousel-dark"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="d-block img-fluid"
                                                        src="/assets/images/blog/blog-img1.jpg" alt="First slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block img-fluid"
                                                        src="/assets/images/blog/blog-img2.jpg" alt="Second slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block img-fluid"
                                                        src="/assets/images/blog/blog-img3.jpg" alt="Third slide">
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls"
                                                role="button" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls"
                                                role="button" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        </div>
                                        <!-- End CAROUSEL -->
                                    </div>
                                    <div class="col-lg-3 mb-4">
                                        <h4 class="mb-3 fs-5">Accordion</h4>
                                        <!-- Accordian -->
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                                        Accordion Item #1
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod
                                                        high life accusamus terry richardson ad squid.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        Accordion Item #2
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingTwo"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod
                                                        high life accusamus terry richardson ad squid.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                                        aria-controls="flush-collapseThree">
                                                        Accordion Item #3
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingThree"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod
                                                        high life accusamus terry richardson ad squid.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-4">
                                        <h4 class="mb-3 fs-5">Contact Us</h4>
                                        <!-- Contact -->
                                        <form>
                                            <div class="mb-3 form-floating">
                                                <input type="text" class="form-control" id="exampleInputname1"
                                                    placeholder="Enter Name">
                                                <label>Enter Name</label>
                                            </div>
                                            <div class="mb-3 form-floating">
                                                <input type="email" class="form-control" placeholder="Enter email">
                                                <label>Enter Email address</label>
                                            </div>
                                            <div class="mb-3 form-floating">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                                <label>Enter Message</label>
                                            </div>
                                            <button type="submit" class="btn px-4 rounded-pill btn-primary">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-lg-3 col-xlg-4 mb-4">
                                        <h4 class="mb-3 fs-5">List style</h4>
                                        <ol class="list-group list-group-numbered px-0">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <h6 class="fw-semibold mb-0">Subheading</h6>
                                                    <div class=" d-block text-muted text-truncate text-truncate">
                                                        Content for list item</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">14</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <h6 class="fw-semibold mb-0">Subheading</h6>
                                                    <div class=" d-block text-muted text-truncate text-truncate">
                                                        Content for list item</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">14</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <h6 class="fw-semibold mb-0">Subheading</h6>
                                                    <div class=" d-block text-muted text-truncate text-truncate">
                                                        Content for list item</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">14</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)"
                                class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                aria-controls="offcanvasWithBothOptions">
                                <iconify-icon icon="solar:menu-dots-circle-linear"></iconify-icon>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover moon dark-layout" href="javascript:void(0)">
                                <iconify-icon icon="solar:moon-line-duotone" class="moon"></iconify-icon>
                            </a>
                            <a class="nav-link nav-icon-hover sun light-layout" href="javascript:void(0)"
                                style="display: none;">
                                <iconify-icon icon="solar:sun-2-line-duotone" class="sun"></iconify-icon>
                            </a>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- start language Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown ">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/assets/images/svgs/icon-flag-en.svg" alt="" width="22px"
                                    height="22px">
                            </a>
                            <div class="dropdown-menu pt-0 dropdown-menu-end dropdown-menu-animate-up mt-n1"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-3 py-2 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="/assets/images/svgs/icon-flag-en.svg" alt=""
                                                width="20px" height="20px" class="  round-20">
                                        </div>
                                        <p class="mb-0 fs-3">English</p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-3 py-2 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="/assets/images/svgs/icon-flag-cn.svg" alt=""
                                                width="20px" height="20px" class="  round-20">
                                        </div>
                                        <p class="mb-0 fs-3">Chinese</p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-3 py-2 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="/assets/images/svgs/icon-flag-fr.svg" alt=""
                                                width="20px" height="20px" class="  round-20">
                                        </div>
                                        <p class="mb-0 fs-3">French</p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-3 py-2 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="/assets/images/svgs/icon-flag-sa.svg" alt=""
                                                width="20px" height="20px" class="  round-20">
                                        </div>
                                        <p class="mb-0 fs-3">Arabic</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/assets/images/profile/Header-Icon-User.png" alt="user" width="30"
                                    class="profile-pic rounded-circle">
                            </a>
                            <div class="dropdown-menu message-box pt-0 content-dd mailbox dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="profile-dropdown position-relative" data-simplebar="">
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 ">Thông tin cá nhân</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="/assets/images/profile/Header-Icon-User.png" class="rounded-circle"
                                            width="80" height="80" alt="">
                                        <div class="ms-3">
                                            @if(isset($currentUser))
                                            <h5 class="mb-1 fs-4 text-secondary">
                                                {{ $currentUser->employee->employee_name ?? $currentUser->employee_name ?? $currentUser->customer->full_name }}
                                            </h5>
                                            @endif
                                            <span class="mb-1 d-block text-secondary">Designer</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> info@xtreme.com
                                            </p>
                                        </div>
                                    </div>
                                    {{-- <div class="message-body">
                                        <a href="{{ route('profile.user') }}"
                                            class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center bg-primary-subtle rounded-circle round p-6 fs-6 text-primary">
                                                <iconify-icon icon="solar:user-circle-line-duotone"
                                                    class="text-primary"></iconify-icon>
                                            </span>
                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                <h6 class="mb-1 fs-3  lh-base">Thông tin cá nhân</h6>
                                                <span class="fs-3 d-block text-secondary">Cài đặt tài khoản</span>
                                            </div>
                                        </a>
                                    </div> --}}
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="{{ route('logout') }}" class="btn btn-primary">Đăng xuất</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
                <div class="offcanvas-header justify-content-between">
                    <div class="brand-logo d-flex align-items-center justify-content-between">
                        <a href="/" class="text-nowrap logo-img">
                            <span class="logo-text">
                                {{-- <img src="{{ asset('/img-system/system/logo.png') }}" class="logo-horizontal ps-2"
                                    alt="homepage"> --}}
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" data-simplebar="" data-simplebar="" style="height: calc(100vh - 80px)">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow ms-0" href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:shield-plus-outline" class="iconify-sm">
                                    </iconify-icon>
                                </span>
                                <span class="hide-menu">Apps</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level my-3">
                                <li class="sidebar-item py-2">
                                    <a href="app-chat.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-chat.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Chat Application</h6>
                                            <span class="fs-3 d-block text-secondary ">New messages
                                                arrived</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-invoice.html" class="d-flex align-items-center ">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-invoice.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Invoice App</h6>
                                            <span class="fs-3 d-block text-secondary ">Get latest
                                                invoice</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-contact.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-mobile.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Contact Application</h6>
                                            <span class="fs-3 d-block text-secondary ">2 Unsaved
                                                Contacts</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-email.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-message-box.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Email App</h6>
                                            <span class="fs-3 d-block text-secondary ">Get new
                                                emails</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="page-user-profile.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-cart.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">User Profile</h6>
                                            <span class="fs-3 d-block text-secondary ">learn more
                                                information</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-calendar.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-date.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Calendar App</h6>
                                            <span class="fs-3 d-block text-secondary ">Get dates</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-contact2.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-lifebuoy.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Contact List Table</h6>
                                            <span class="fs-3 d-block text-secondary ">Add new
                                                contact</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="app-notes.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                            <img src="/assets/images/svgs/icon-dd-application.svg" alt=""
                                                class="img-fluid" width="24" height="24">
                                        </div>
                                        <div class="d-inline-block">
                                            <h6 class="mb-1 bg-hover-primary">Notes Application</h6>
                                            <span class="fs-3 d-block text-secondary ">To-do and Daily
                                                tasks</span>
                                        </div>
                                    </a>
                                </li>
                                <ul class="px-8 mt-7 mb-4">
                                    <li class="sidebar-item mb-3">
                                        <h5 class="fs-5 fw-semibold">Quick Links</h5>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary" href="page-pricing.html">Pricing
                                            Page</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary"
                                            href="authentication-login.html">Authentication Design</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary"
                                            href="authentication-register.html">Register Now</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary" href="authentication-error.html">404
                                            Error Page</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary" href="app-notes.html">Notes
                                            App</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary" href="page-user-profile.html">User
                                            Application</a>
                                    </li>
                                    <li class="mb-3">
                                        <a class="fw-semibold bg-hover-primary"
                                            href="page-account-settings.html">Account Settings</a>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link  ms-0" href="app-chat.html" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:chat-unread-outline" class="iconify-sm">
                                    </iconify-icon>
                                </span>
                                <span class="hide-menu">Chat</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link  ms-0" href="app-calendar.html" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:calendar-minimalistic-outline"
                                        class="iconify-sm"></iconify-icon>
                                </span>
                                <span class="hide-menu">Calendar</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link  ms-0" href="app-email.html" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:inbox-unread-outline" class="iconify-sm">
                                    </iconify-icon>
                                </span>
                                <span class="hide-menu">Email</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <div class="container-xxxl">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <div class="brand-logo d-flex align-items-center justify-content-between">
                            <a href="/" class="text-nowrap logo-img">
                                <span class="">
                                    {{-- <img src="{{ asset('/img-system/system/logo.png') }}" class="logo-horizontal ps-2"
                                        alt="homepage"> --}}
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
                @include('partial.aside-horizontal')

                <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="p-2">
                        <iconify-icon icon="solar:menu-dots-bold" class="fs-7"></iconify-icon>
                    </span>
                </a>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                        <a href="javascript:void(0)"
                            class="nav-link round p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                            aria-controls="offcanvasWithBothOptions">
                            <i class="ti ti-align-justified fs-7"></i>
                        </a>
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="/assets/images/profile/Header-Icon-User.png" alt="user" width="30"
                                        class="profile-pic rounded-circle">
                                </a>
                                <div class="dropdown-menu message-box pt-0 content-dd mailbox dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="profile-dropdown position-relative" data-simplebar="">
                                        <div class="py-3 px-7 pb-0">
                                            <h5 class="mb-0 fs-5 ">Thông tin cá nhân</h5>
                                        </div>
                                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                            <img src="/assets/images/profile/Header-Icon-User.png" class="rounded-circle"
                                                width="80" height="80" alt="">
                                            @if(isset($currentUser))
                                            <div class="ms-3">
                                                <h5 class="mb-1 fs-4 text-secondary">
                                                    {{ $currentUser->employee->employee_name ?? $currentUser->employee_name ?? $currentUser->customer->full_name }}</h5>
                                                <span
                                                    class="mb-1 d-block text-secondary">{{ $currentUser->role_name }}</span>
                                                <p class="mb-0 d-flex align-items-center gap-2">
                                                    <i class="ti ti-mail fs-4"></i> {{ $currentUser->employee->email ?? $currentUser->hospital->email ?? $currentUser->customer->email }}
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="message-body">
                                            {{-- <a href="{{ route('profile.user') }}"
                                                class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span
                                                    class="d-flex align-items-center justify-content-center bg-warning-subtle rounded-circle round p-6 fs-6 text-primary">
                                                    <iconify-icon icon="solar:user-circle-line-duotone"
                                                        class="text-primary"></iconify-icon>
                                                </span>
                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                    <h6 class="mb-1 fs-3  lh-base">Thông tin cá nhân</h6>
                                                    <span class="fs-3 d-block text-secondary">Cài đặt tài khoản</span>
                                                </div>
                                            </a> --}}
                                            <a href="{{ route('profile.changePassword') }}"
                                                class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span
                                                    class="d-flex align-items-center justify-content-center bg-success-subtle rounded-circle round p-6 fs-6 text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-password-fingerprint" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 8c.788 1 1 2 1 3v1"></path><path d="M9 11c0 -1.578 1.343 -3 3 -3s3 1.422 3 3v2"></path><path d="M12 11v2"></path><path d="M6 12v-1.397c-.006 -1.999 1.136 -3.849 2.993 -4.85a6.385 6.385 0 0 1 6.007 -.005"></path><path d="M12 17v4"></path><path d="M10 20l4 -2"></path><path d="M10 18l4 2"></path><path d="M5 17v4"></path><path d="M3 20l4 -2"></path><path d="M3 18l4 2"></path><path d="M19 17v4"></path><path d="M17 20l4 -2"></path><path d="M17 18l4 2"></path></svg>
                                                </span>
                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                    <h6 class="mb-1 fs-3  lh-base">Đổi mật khẩu</h6>
                                                    <span class="fs-3 d-block text-secondary">Bảo mật</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-grid py-4 px-7 pt-8">
                                            <a href="{{ route('logout') }}" class="btn btn-primary">Đăng xuất</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>


<!--  Search Bar -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-1">
            <div class="modal-header border-bottom">
                <input type="search" class="form-control fs-3" placeholder="Search here" id="search">
                <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                    <i class="ti ti-x fs-5 ms-3"></i>
                </a>
            </div>
            <div class="modal-body message-body" data-simplebar="">
                <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                <ul class="list mb-0 py-2">
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Modern</span>
                            <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Dashboard</span>
                            <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Contacts</span>
                            <span class="fs-3 text-muted d-block">/apps/contacts</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Posts</span>
                            <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Detail</span>
                            <span
                                class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Shop</span>
                            <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Modern</span>
                            <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Dashboard</span>
                            <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Contacts</span>
                            <span class="fs-3 text-muted d-block">/apps/contacts</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Posts</span>
                            <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  h6 mb-0 d-block">Detail</span>
                            <span
                                class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                        </a>
                    </li>
                    <li class="p-1 mb-1 px-2 rounded bg-hover-light-black">
                        <a href="#">
                            <span class="fs-3  fw-normal d-block">Shop</span>
                            <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
