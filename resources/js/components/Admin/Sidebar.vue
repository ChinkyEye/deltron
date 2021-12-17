<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/manager" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
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
    
    <!-- <li class="nav-item">
      <router-link to="/user" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          User
        </p>
      </router-link>
    </li> -->
    
    <!-- <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Customer
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item" v-for="usertype in getAllUsertype">
          <router-link :to="`/customer/${usertype.id}`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>{{usertype.name}}</p>
          </router-link>
        </li>
      </ul>
    </li> -->
    <!-- <li class="nav-item">
      <router-link to="/user" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          User
        </p>
      </router-link>
    </li> -->
    <!-- <li class="nav-item">
      <router-link to="/category" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Category
        </p>
      </router-link>
    </li> -->
    
    <!-- <li class="nav-item">
      <router-link to="/package" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Package
        </p>
      </router-link>
    </li> -->
    
    
    
    
    
    
    
    <!-- <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Salary
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
      <router-link to="/salary/create" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Add Salary
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/salary" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Salary
        </p>
      </router-link>
    </li>
      </ul>
    </li> -->
    <!-- <li class="nav-item">
      <router-link to="/testcategory" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          TestCategory
        </p>
      </router-link>
    </li> -->
  </ul>
</template>

