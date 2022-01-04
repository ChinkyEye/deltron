// dashboard
import Dashboard from './components/admin/Home.vue'
// manager component
import Manager from './components/admin/manager/List.vue'
import ManagerNew from './components/admin/manager/New.vue'
import ManagerEdit from './components/admin/manager/Edit.vue'
import ChangePassword from './components/admin/manager/Password.vue'
 
 //
import Revise from './components/admin/revise/List.vue'
import Report from './components/admin/report/List.vue'

import TpnpReport from './components/admin/report/tpnp/List.vue'






export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
	},
	// user-type routes buyer1 seller2
	{ 
		path:'/manager', 
		component: Manager
	},
	{
		path:'/manager/create',
		component: ManagerNew
	},
	{
		path:'/manager/:managerid/edit',
		component: ManagerEdit
	},
	{
		path:'/manager/:managerid/changepassword',
		component: ChangePassword
	},

	//revise
	{
		path:'/revise',
		component: Revise
	},
	{
		path:'/report',
		name: 'report',
		component:Report
	},
	{
		path:'/report/tpnp',
		component: TpnpReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},

]