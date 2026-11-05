<div class="offcanvas offcanvas-end bg-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
    <div class="offcanvas-header bg-primary py-3 px-4">
        <h5 class="offcanvas-title fs-18 text-white" id="offcanvasScrollingLabel">Theme Settings</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close" style="filter: invert(1); opacity: 1;"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">RTL / LTR</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-rtl-mode" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">LTR</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box for-rtl">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">RTL</span>
                    </div>
                </div>
                <label id="switch" class="switch-for-rtl">
                    <input type="checkbox" class="position-absolute top-0 bottom-0 start-0 end-0 opacity-0 cursor" onchange="toggleTheme()" id="slider">
                    <span class="sliders round"></span>
                </label>
            </div>
        </div>

        <!-- <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Container Style Fluid / Boxed</h4>
            <button class="boxed-style settings-btn fluid-boxed-btn" id="boxed-style">
                Click To <span class="fluid">Fluid</span> <span class="boxed">Boxed</span>
            </button>
        </div> -->

        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Sidebar Light / Dark</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-sidebar-dark" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Light</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Dark</span>
                    </div>
                </div>
                <button class="sidebar-light-dark settings-btn" id="sidebar-light-dark"></button>
            </div>
        </div>

        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Header Light / Dark</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-header-dark" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Light</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Dark</span>
                    </div>
                </div>
                <button class="header-light-dark settings-btn" id="header-light-dark"></button>
            </div>
        </div>

        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Footer Light / Dark</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-footer-dark" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Light</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Dark</span>
                    </div>
                </div>
                <button class="footer-light-dark settings-btn" id="footer-light-dark"></button>
            </div>
        </div>

        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style Radius / Square</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-card-radius" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Radius</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box rounded-0">
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span class="rounded-0"></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Square</span>
                    </div>
                </div>
                <button class="card-radius-square settings-btn" id="card-radius-square"></button>
            </div>
        </div>

        <div class="mb-4 pb-2">
            <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style BG White / Gray</h4>

            <div class="d-flex align-items-center position-relative settings-box-wrap for-card-bg-gray" style="gap: 25px;">
                <div class="cursor position-relative active-wrap2">
                    <div class="settings-box bg-light-40">
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                        <span class="rounded-3 bg-white"></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">White</span>
                    </div>
                </div>
                <div class="cursor position-relative active-wrap1">
                    <div class="settings-box">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                        <span class="rounded-3"></span>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                        <i class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                        <i class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                        <span class="fw-semibold">Gray</span>
                    </div>
                </div>
                <button class="card-bg settings-btn" id="card-bg"></button>
            </div>
        </div>
    </div>
</div>