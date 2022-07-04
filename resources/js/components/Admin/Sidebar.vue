<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/manager" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p class="text-danger">
          Manager
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/revise" class="nav-link">
        <i class="nav-icon fas fa-undo"></i>
        <p>
          Revised
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/overview" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        <p>
          Overview Report
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/detail" class="nav-link">
        <i class="nav-icon fas fa-eye"></i>
        <p>
          Detail
        </p>
      </router-link>
    </li>
    <!-- <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          View More
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/luckydraw" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Scheme
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/kista" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Kista
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/agent" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Agent
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/clientlist" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Member
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/incomeexpenditurelist" class="nav-link">
            <i class="nav-icon fas fa-comments-dollar"></i>
            <p>
              Income and Expenditure
            </p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link to="/bankbalance" class="nav-link">
            <i class="nav-icon fas fa-landmark"></i>
            <p>
              Bank Balance
            </p>
          </router-link>
        </li>
      </ul>
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
    </li> -->
  </ul>
</template>

