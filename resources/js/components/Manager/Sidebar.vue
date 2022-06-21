<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/luckydraw" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Scheme
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/kista" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Kista
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/agent" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Agent
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/detail" class="nav-link">
        <i class="nav-icon fas fa-coins"></i>
        <p>
          Details
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/kistahasopening" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Kista Has Closing
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/lotteryprize" class="nav-link">
        <!-- <i class="nav-icon fas fa-comments-dollar"></i> -->
        <i class="nav-icon fas fa-award"></i>
        <p>
          Scheme Prize
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/remaining" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Remainer
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/clientlist" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Member
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/incomeexpenditurelist" class="nav-link">
        <i class="nav-icon fas fa-comments-dollar"></i>
        <p>
          Income and Expenditure
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/bankbalance" class="nav-link">
        <i class="nav-icon fas fa-landmark"></i>
        <p>
          Bank Balance
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Detail-Entry
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/record" class="nav-link">
            <i class="nav-icon fa fa-file"></i>
            <p>
              Record
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/purchase" class="nav-link">
            <i class="nav-icon fas fa-circle"></i>
            <p>
              Purchase
            </p>
          </router-link>
        </li>
      </ul>
    </li>
    
    <li class="nav-item">
      <router-link to="/booking" class="nav-link">
        <i class="nav-icon fab fa-bootstrap"></i>
        <p>
          Booking
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/payment" class="nav-link">
        <i class="nav-icon fas fa-handshake"></i>
        <p>
          Payment
        </p>
      </router-link>
    </li>
    
  </ul>
</template>

