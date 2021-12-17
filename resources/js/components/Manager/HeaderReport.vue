<template>
  <aside class="control-sidebar control-sidebar-dark sidebar-dark-primary">
    <div class="sidebar">
      <nav class="p-2 control-sidebar-content">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/report/tpnp" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
               TPNP Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/tpnpl" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                TPNPL Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/agent" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Agent Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/expense" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Expense Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/lotteryprize" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Lottery Prize Report
              </span>
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>
<style scoped>
/*.control-sidebar .control-sidebar-dark{
  z-index: 999;
}*/
</style>