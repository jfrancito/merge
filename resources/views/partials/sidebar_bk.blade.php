<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="index" class="d-block text-decoration-none position-relative">
            <img src="{{ asset('assets/images/logo-appmovil.png') }}" alt="logo-icon">
            <span class="logo-text fw-bold text-dark">App Movil</span>
        </a>
        <button
            class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y"
            id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>

    <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
        <ul class="menu-inner">
            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">MAIN</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Dashboard</span>
                    <span class="count">20</span>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/" class="menu-link {{ Request::is('/') ? 'active' : '' }}">
                            Inicio
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/crm" class="menu-link {{ Request::is('crm') ? 'active' : '' }}">
                            CRM
                            <span class="hot tag">Hot</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/project-management"
                            class="menu-link {{ Request::is('project-management') ? 'active' : '' }}">
                            Project Management
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/lms" class="menu-link {{ Request::is('lms') ? 'active' : '' }}">
                            LMS
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/help-desk" class="menu-link {{ Request::is('help-desk') ? 'active' : '' }}">
                            HelpDesk
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/analytics" class="menu-link {{ Request::is('analytics') ? 'active' : '' }}">
                            Analytics
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/crypto" class="menu-link {{ Request::is('crypto') ? 'active' : '' }}">
                            Crypto
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/sales" class="menu-link {{ Request::is('sales') ? 'active' : '' }}">
                            Sales
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/hospital" class="menu-link {{ Request::is('hospital') ? 'active' : '' }}">
                            Hospital
                        </a>
                    </li>

                    <li class="menu-item mb-0">
                        <a href="/marketing" class="menu-link {{ Request::is('marketing') ? 'active' : '' }}">
                            Marketing
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/nft" class="menu-link {{ Request::is('nft') ? 'active' : '' }}">
                            NFT
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/saas" class="menu-link {{ Request::is('saas') ? 'active' : '' }}">
                            SaaS
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/real-estate" class="menu-link {{ Request::is('real-estate') ? 'active' : '' }}">
                            Real Estate
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/shipment" class="menu-link {{ Request::is('shipment') ? 'active' : '' }}">
                            Shipment
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/finance" class="menu-link {{ Request::is('finance') ? 'active' : '' }}">
                            Finance
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/hrm" class="menu-link {{ Request::is('hrm') ? 'active' : '' }}">
                            HRM
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/school" class="menu-link {{ Request::is('school') ? 'active' : '' }}">
                            School
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/call-center" class="menu-link {{ Request::is('call-center') ? 'active' : '' }}">
                            Call Center
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/pos-system" class="menu-link {{ Request::is('call-center') ? 'active' : '' }}">
                            POS System
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/pos-system" class="menu-link {{ Request::is('pos-system') ? 'active' : '' }}">
                            POS System
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/podcast" class="menu-link {{ Request::is('podcast') ? 'active' : '' }}">
                            Podcast
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/social-media" class="menu-link {{ Request::is('social-media') ? 'active' : '' }}">
                            Social Media
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/doctor" class="menu-link {{ Request::is('doctor') ? 'active' : '' }}">
                            Doctor
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/beauty-salon" class="menu-link {{ Request::is('beauty-salon') ? 'active' : '' }}">
                            Beauty Salon
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/store-analytics"
                            class="menu-link {{ Request::is('store-analytics') ? 'active' : '' }}">
                            Store Analytics
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/restaurant" class="menu-link {{ Request::is('restaurant') ? 'active' : '' }}">
                            Restaurant
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/hotel" class="menu-link {{ Request::is('hotel') ? 'active' : '' }}">
                            Hotel
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/real-estate-agent"
                            class="menu-link {{ Request::is('real-estate-agent') ? 'active' : '' }}">
                            Real Estate Agent
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/credit-card" class="menu-link {{ Request::is('credit-card') ? 'active' : '' }}">
                            Credit Card
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/crypto-trader" class="menu-link {{ Request::is('crypto-trader') ? 'active' : '' }}">
                            Crypto Trader
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                    <li class="menu-item mb-0">
                        <a href="/crypto-performance" class="menu-link {{ Request::is('xa') ? 'active' : '' }}">
                            Crypto Perf.
                            <span class="hot tag">New</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">note_stack</span>
                    <span class="title">Front Pages</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/landing-page" class="menu-link {{ Request::is('landing-page') ? 'active' : '' }}">
                            Landing Page
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/pricing-plan" class="menu-link {{ Request::is('pricing-plan') ? 'active' : '' }}">
                            Pricing Plan
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/faq" class="menu-link {{ Request::is('faq') ? 'active' : '' }}">
                            FAQ
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/timeline" class="menu-link {{ Request::is('timeline') ? 'active' : '' }}">
                            Timeline
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">APPS</span>
            </li>

            <li class="menu-item">
                <a href="/calender" class="menu-link {{ Request::is('calender') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">date_range</span>
                    <span class="title">Calender</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/to-do-list" class="menu-link {{ Request::is('to-do-list') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">format_list_bulleted</span>
                    <span class="title">To Do List</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/contacts" class="menu-link {{ Request::is('contacts') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">contact_page</span>
                    <span class="title">Contacts</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/chat" class="menu-link {{ Request::is('chat') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">chat</span>
                    <span class="title">Chat</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">mail</span>
                    <span class="title">Email</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/inbox" class="menu-link {{ Request::is('inbox') ? 'active' : '' }}">
                            Inbox
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/compose" class="menu-link {{ Request::is('compose') ? 'active' : '' }}">
                            Compose
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/read-email" class="menu-link {{ Request::is('read-email') ? 'active' : '' }}">
                            Read Email
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/snoozed" class="menu-link {{ Request::is('snoozed') ? 'active' : '' }}">
                            Snoozed
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/draft" class="menu-link {{ Request::is('draft') ? 'active' : '' }}">
                            Draft
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/sent-mail" class="menu-link {{ Request::is('sent-mail') ? 'active' : '' }}">
                            Sent Mail
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/trash-email" class="menu-link {{ Request::is('trash-email') ? 'active' : '' }}">
                            Trash
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/spam" class="menu-link {{ Request::is('spam') ? 'active' : '' }}">
                            Spam
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/starred" class="menu-link {{ Request::is('starred') ? 'active' : '' }}">
                            Starred
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/important" class="menu-link {{ Request::is('important') ? 'active' : '' }}">
                            Important
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="kanban-board" class="menu-link {{ Request::is('kanban-board') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">space_dashboard</span>
                    <span class="title">Kanban Board</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">folder</span>
                    <span class="title">File Manager</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/file-manager" class="menu-link {{ Request::is('file-manager') ? 'active' : '' }}">
                            My Drive
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/assets-manager" class="menu-link {{ Request::is('assets-manager') ? 'active' : '' }}">
                            Assets
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/projects" class="menu-link {{ Request::is('projects') ? 'active' : '' }}">
                            Projects
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/personal" class="menu-link {{ Request::is('personal') ? 'active' : '' }}">
                            Personal
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/applications" class="menu-link {{ Request::is('applications') ? 'active' : '' }}">
                            Applications
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/documents" class="menu-link {{ Request::is('documents') ? 'active' : '' }}">
                            Documents
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/media" class="menu-link {{ Request::is('media') ? 'active' : '' }}">
                            Media
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">PAGES</span>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">shopping_cart</span>
                    <span class="title">eCommerce</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/products-grid" class="menu-link {{ Request::is('products-grid') ? 'active' : '' }}">
                            Products Grid
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/products-list" class="menu-link {{ Request::is('products-list') ? 'active' : '' }}">
                            Products List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/product-details"
                            class="menu-link {{ Request::is('product-details') ? 'active' : '' }}">
                            Product Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-product" class="menu-link {{ Request::is('create-product') ? 'active' : '' }}">
                            Create Product
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/edit-product" class="menu-link {{ Request::is('edit-product') ? 'active' : '' }}">
                            Edit Product
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/cart" class="menu-link {{ Request::is('cart') ? 'active' : '' }}">
                            Cart
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/checkout" class="menu-link {{ Request::is('checkout') ? 'active' : '' }}">
                            Checkout
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/orders" class="menu-link {{ Request::is('orders') ? 'active' : '' }}">
                            Orders
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/order-details" class="menu-link {{ Request::is('order-details') ? 'active' : '' }}">
                            Order Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-order" class="menu-link {{ Request::is('create-order') ? 'active' : '' }}">
                            Create Order
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/order-tracking" class="menu-link {{ Request::is('order-tracking') ? 'active' : '' }}">
                            Order Tracking
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/customers" class="menu-link {{ Request::is('customers') ? 'active' : '' }}">
                            Customers
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/customer-details"
                            class="menu-link {{ Request::is('customer-details') ? 'active' : '' }}">
                            Customer Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/categories" class="menu-link {{ Request::is('categories') ? 'active' : '' }}">
                            Categories
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/sellers" class="menu-link {{ Request::is('sellers') ? 'active' : '' }}">
                            Sellers
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/seller-details" class="menu-link {{ Request::is('seller-details') ? 'active' : '' }}">
                            Seller Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-seller" class="menu-link {{ Request::is('create-seller') ? 'active' : '' }}">
                            Create Seller
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/reviews" class="menu-link {{ Request::is('reviews') ? 'active' : '' }}">
                            Reviews
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/refunds" class="menu-link {{ Request::is('refunds') ? 'active' : '' }}">
                            Refunds
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">handshake</span>
                    <span class="title">CRM</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/contacts-2" class="menu-link {{ Request::is('contacts-2') ? 'active' : '' }}">
                            Contacts
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/customers-2" class="menu-link {{ Request::is('customers-2') ? 'active' : '' }}">
                            Customers
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/leads" class="menu-link {{ Request::is('leads') ? 'active' : '' }}">
                            Leads
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/deals" class="menu-link {{ Request::is('deals') ? 'active' : '' }}">
                            Deals
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">content_paste</span>
                    <span class="title">Project Management</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/project-overview"
                            class="menu-link {{ Request::is('project-overview') ? 'active' : '' }}">
                            Project Overview
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/project-list" class="menu-link {{ Request::is('project-list') ? 'active' : '' }}">
                            Project List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-project" class="menu-link {{ Request::is('create-project') ? 'active' : '' }}">
                            Create Project
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/clients" class="menu-link {{ Request::is('clients') ? 'active' : '' }}">
                            Clients
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/teams" class="menu-link {{ Request::is('teams') ? 'active' : '' }}">
                            Teams
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/kanban-board-2" class="menu-link {{ Request::is('kanban-board-2') ? 'active' : '' }}">
                            Kanvan Board
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/user" class="menu-link {{ Request::is('user') ? 'active' : '' }}">
                            User
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">auto_stories</span>
                    <span class="title">LMS</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/courses-list" class="menu-link {{ Request::is('courses-list') ? 'active' : '' }}">
                            Courses List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/course-details" class="menu-link {{ Request::is('course-details') ? 'active' : '' }}">
                            Course Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/lesson-preview" class="menu-link {{ Request::is('lesson-preview') ? 'active' : '' }}">
                            Lesson Preview
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-course" class="menu-link {{ Request::is('create-course') ? 'active' : '' }}">
                            Create Course
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/edit-course" class="menu-link {{ Request::is('edit-course') ? 'active' : '' }}">
                            Edit Course
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/instructors" class="menu-link {{ Request::is('instructors') ? 'active' : '' }}">
                            Instructors
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">support</span>
                    <span class="title">Help Desk</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/tickets" class="menu-link {{ Request::is('tickets') ? 'active' : '' }}">
                            Tickets
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/ticket-details" class="menu-link {{ Request::is('ticket-details') ? 'active' : '' }}">
                            Ticket Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/agents" class="menu-link {{ Request::is('agents') ? 'active' : '' }}">
                            Agents
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/reports" class="menu-link {{ Request::is('reports') ? 'active' : '' }}">
                            Reports
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">local_activity</span>
                    <span class="title">Events</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/events" class="menu-link {{ Request::is('events') ? 'active' : '' }}">
                            Events
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/events-list" class="menu-link {{ Request::is('events-list') ? 'active' : '' }}">
                            Events List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/event-details" class="menu-link {{ Request::is('event-details') ? 'active' : '' }}">
                            Event Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-an-event"
                            class="menu-link {{ Request::is('create-an-event') ? 'active' : '' }}">
                            Create An Event
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/edit-an-event" class="menu-link {{ Request::is('edit-an-event') ? 'active' : '' }}">
                            Edit An Event
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">share</span>
                    <span class="title">Social</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/profile" class="menu-link {{ Request::is('profile') ? 'active' : '' }}">
                            Profile
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/settings" class="menu-link {{ Request::is('settings') ? 'active' : '' }}">
                            Settings
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">content_paste</span>
                    <span class="title">Invoice</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/invoice-list" class="menu-link {{ Request::is('invoice-list') ? 'active' : '' }}">
                            Invoice List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/invoice-details"
                            class="menu-link {{ Request::is('invoice-details') ? 'active' : '' }}">
                            Invoice Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/create-invoice" class="menu-link {{ Request::is('create-invoice') ? 'active' : '' }}">
                            Create Invoice
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/edit-invoice" class="menu-link {{ Request::is('edit-invoice') ? 'active' : '' }}">
                            Edit Invoice
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">group_add</span>
                    <span class="title">Users</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/team-members" class="menu-link {{ Request::is('team-members') ? 'active' : '' }}">
                            Team Members
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/users-list" class="menu-link {{ Request::is('users-list') ? 'active' : '' }}">
                            Users List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/add-user" class="menu-link {{ Request::is('add-user') ? 'active' : '' }}">
                            Add User
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">account_circle</span>
                    <span class="title">Profile</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/user-profile" class="menu-link {{ Request::is('user-profile') ? 'active' : '' }}">
                            User Profile
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/teams-2" class="menu-link {{ Request::is('teams-2') ? 'active' : '' }}">
                            Teams
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/my-projects" class="menu-link {{ Request::is('my-projects') ? 'active' : '' }}">
                            Projects
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="starter" class="menu-link {{ Request::is('starter') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">star</span>
                    <span class="title">Starter</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">MODULES</span>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">add_reaction</span>
                    <span class="title">Icons</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/material-icons" class="menu-link {{ Request::is('material-icons') ? 'active' : '' }}">
                            Material Icons
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/feathericon" class="menu-link {{ Request::is('feathericon') ? 'active' : '' }}">
                            Feathericon
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/remixicon" class="menu-link {{ Request::is('remixicon') ? 'active' : '' }}">
                            Remixicon
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">gallery_thumbnail</span>
                    <span class="title">UI Elements</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/alerts" class="menu-link {{ Request::is('alerts') ? 'active' : '' }}">
                            Alerts
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/avatar" class="menu-link {{ Request::is('avatar') ? 'active' : '' }}">
                            Avatar
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/buttons" class="menu-link {{ Request::is('buttons') ? 'active' : '' }}">
                            Buttons
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/badges" class="menu-link {{ Request::is('badges') ? 'active' : '' }}">
                            Badges
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/cards" class="menu-link {{ Request::is('cards') ? 'active' : '' }}">
                            Cards
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/carousels" class="menu-link {{ Request::is('carousels') ? 'active' : '' }}">
                            Carousels
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/dropdowns" class="menu-link {{ Request::is('dropdowns') ? 'active' : '' }}">
                            Dropdowns
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/grids" class="menu-link {{ Request::is('grids') ? 'active' : '' }}">
                            Grids
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/images" class="menu-link {{ Request::is('images') ? 'active' : '' }}">
                            Images
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/list" class="menu-link {{ Request::is('list') ? 'active' : '' }}">
                            List
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/modals" class="menu-link {{ Request::is('modals') ? 'active' : '' }}">
                            Modals
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/navs" class="menu-link {{ Request::is('navs') ? 'active' : '' }}">
                            Navs
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/paginations" class="menu-link {{ Request::is('paginations') ? 'active' : '' }}">
                            Paginations
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/popover-tooltips"
                            class="menu-link {{ Request::is('popover-tooltips') ? 'active' : '' }}">
                            Popover Tooltips
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/progess" class="menu-link {{ Request::is('progess') ? 'active' : '' }}">
                            Progess
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/spinners" class="menu-link {{ Request::is('spinners') ? 'active' : '' }}">
                            Spinners
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/tabs" class="menu-link {{ Request::is('tabs') ? 'active' : '' }}">
                            Tabs
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/accoridions" class="menu-link {{ Request::is('accoridions') ? 'active' : '' }}">
                            Accoridions
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/date-time-picker"
                            class="menu-link {{ Request::is('date-time-picker') ? 'active' : '' }}">
                            Date/Time Picker
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/videos" class="menu-link {{ Request::is('videos') ? 'active' : '' }}">
                            Videos
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">table</span>
                    <span class="title">Tables</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/basic-table" class="menu-link {{ Request::is('basic-table') ? 'active' : '' }}">
                            Basic Table
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/data-tables" class="menu-link {{ Request::is('data-tables') ? 'active' : '' }}">
                            Data Table
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">clarify</span>
                    <span class="title">Forms</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/basic-elements" class="menu-link {{ Request::is('basic-elements') ? 'active' : '' }}">
                            Basic Elements
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/advanced-elements"
                            class="menu-link {{ Request::is('advanced-elements') ? 'active' : '' }}">
                            Advanced Elements
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/validation" class="menu-link {{ Request::is('validation') ? 'active' : '' }}">
                            Validation
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/wizard" class="menu-link {{ Request::is('wizard') ? 'active' : '' }}">
                            Wizard
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/editors" class="menu-link {{ Request::is('editors') ? 'active' : '' }}">
                            Editors
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/file-upload" class="menu-link {{ Request::is('file-upload') ? 'active' : '' }}">
                            File Upload
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="/apex-charts" class="menu-link {{ Request::is('apex-charts') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">donut_large</span>
                    <span class="title">Apex Charts</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">lock</span>
                    <span class="title">Authentication</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/login" class="menu-link {{ Request::is('login') ? 'active' : '' }}">
                            Login
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/register" class="menu-link {{ Request::is('register') ? 'active' : '' }}">
                            Register
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">featured_video</span>
                    <span class="title">Extra Pages</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/animation" class="menu-link {{ Request::is('animation') ? 'active' : '' }}">
                            Animation
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/clip-board" class="menu-link {{ Request::is('clip-board') ? 'active' : '' }}">
                            Clip Board
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/drag-drop" class="menu-link {{ Request::is('drag-drop') ? 'active' : '' }}">
                            Drag & Drop
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/range-slider" class="menu-link {{ Request::is('range-slider') ? 'active' : '' }}">
                            Range Slider
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/ratings" class="menu-link {{ Request::is('ratings') ? 'active' : '' }}">
                            Ratings
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/toasts" class="menu-link {{ Request::is('toasts') ? 'active' : '' }}">
                            Toasts
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/check-radio" class="menu-link {{ Request::is('check-radio') ? 'active' : '' }}">
                            Check & Radio
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="/select" class="menu-link {{ Request::is('select') ? 'active' : '' }}">
                            Select
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/scrollbar" class="menu-link {{ Request::is('scrollbar') ? 'active' : '' }}">
                            Scrollbar
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/typography" class="menu-link {{ Request::is('typography') ? 'active' : '' }}">
                            Typography
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/gallery" class="menu-link {{ Request::is('gallery') ? 'active' : '' }}">
                            Gallery
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/search" class="menu-link {{ Request::is('search') ? 'active' : '' }}">
                            Search
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/blank-page" class="menu-link {{ Request::is('blank-page') ? 'active' : '' }}">
                            Blank Page
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">chat_error</span>
                    <span class="title">Errors</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/404-error-page" class="menu-link {{ Request::is('404-error-page') ? 'active' : '' }}">
                            404 Error Page
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/internal-error" class="menu-link {{ Request::is('internal-error') ? 'active' : '' }}">
                            Internal Error
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="/widgets" class="menu-link {{ Request::is('widgets') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">widgets</span>
                    <span class="title">Widgets</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/google-map" class="menu-link {{ Request::is('google-map') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">map</span>
                    <span class="title">Google Map</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/notification" class="menu-link {{ Request::is('notification') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">notifications</span>
                    <span class="title">Notification</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="/members" class="menu-link {{ Request::is('members') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">group</span>
                    <span class="title">Members</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">OTHERS</span>
            </li>

            <li class="menu-item">
                <a href="/my-profile" class="menu-link {{ Request::is('my-profile') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">account_circle</span>
                    <span class="title">My Profile</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">settings</span>
                    <span class="title">Settings</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/account-settings"
                            class="menu-link {{ Request::is('account-settings') ? 'active' : '' }}">
                            Account Settings
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/change-password"
                            class="menu-link {{ Request::is('change-password') ? 'active' : '' }}">
                            Change Password
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/connections" class="menu-link {{ Request::is('connections') ? 'active' : '' }}">
                            Connections
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/privacy-policy" class="menu-link {{ Request::is('privacy-policy') ? 'active' : '' }}">
                            Privacy Policy
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/terms-conditions"
                            class="menu-link {{ Request::is('terms-conditions') ? 'active' : '' }}">
                            Terms & Conditions
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">keyboard_arrow_down</span>
                    <span class="title">Multi Level Menu</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item after-sub-menu">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <span class="title">Level One</span>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link {{ Request::is('/') ? 'active' : '' }}">
                                    Level Three
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="{{ url('cerrarsession') }}" class="menu-link logout">
                    <span class="material-symbols-outlined menu-icon">logout</span>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</div>