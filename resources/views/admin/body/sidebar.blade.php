<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      Admin<span>Panel</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">RealEstate</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Property Type </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="emails">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('all.type') }}" class="nav-link">All Type</a>
            </li>
            <li class="nav-item">
              <a href="pages/email/read.html" class="nav-link">Add Type</a>
            </li>
            
          </ul>
        </div>
      </li>


       <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#amenitie" role="button" aria-expanded="false" aria-controls="emails">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Amenitie  </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="amenitie">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('all.amenitie') }}" class="nav-link">All Amenitie</a>
            </li>
            <li class="nav-item">
              <a href="pages/email/read.html" class="nav-link">Add Amenitie</a>
            </li>
            
          </ul>
        </div>
      </li>


       <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="emails">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Property  </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="property">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('all.property') }}" class="nav-link">All Property</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('add.property') }}" class="nav-link">Add Property</a>
            </li>
            
          </ul>
        </div>
      </li>
      
      <li class="nav-item">
        <a href="{{route('admin.package.history')}}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Package History</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{route('admin.property.message')}}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Property Message</span>
        </a>
      </li>

      <li class="nav-item nav-category">User All Function</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
          <i class="link-icon" data-feather="feather"></i>
          <span class="link-title">Manage Agent </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="uiComponents">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('all.agent') }}" class="nav-link">All Agent </a>
            </li>
            <li class="nav-item">
              <a href="pages/ui-components/alerts.html" class="nav-link">Add Agent</a>
            </li>
            
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>