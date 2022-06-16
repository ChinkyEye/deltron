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
import TpnplReport from './components/admin/report/tpnpl/List.vue'
import AgentReport from './components/admin/report/agent/List.vue'
import PurchaseReport from './components/admin/report/purchase/List.vue'
import IncomeExpenditureReport from './components/admin/report/incomeexpenditure/List.vue'






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
	{
		path:'/report/tpnpl',
		component: TpnplReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/agent',
		component: AgentReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/purchase',
		component: PurchaseReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/incomeexpenditure',
		component: IncomeExpenditureReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},

]