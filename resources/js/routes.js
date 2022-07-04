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

import LuckyDraw from './components/admin/luckydraw/List.vue'
import Kista from './components/admin/kista/List.vue'
import Agent from './components/admin/agent/List.vue'
import ClientList from './components/admin/clientlist/List.vue'
import BankBalance from './components/admin/bankbalance/List.vue'
import IncomeExpenditureList from './components/admin/incomeexpenditure/List.vue'
import Record from './components/admin/record/List.vue'
import Purchase from './components/admin/purchase/List.vue'
import Overview from './components/admin/overview/List.vue'
import Viewall from './components/admin/overview/viewall.vue'



import TpnpReport from './components/admin/report/tpnp/List.vue'
import TpnplReport from './components/admin/report/tpnpl/List.vue'
import AgentReport from './components/admin/report/agent/List.vue'
import PurchaseReport from './components/admin/report/purchase/List.vue'
import IncomeExpenditureReport from './components/admin/report/incomeexpenditure/List.vue'
import ExpenditureReport from './components/admin/report/expenditure/List.vue'
import RecordReport from './components/admin/report/record/List.vue'
import LotteryPrizeReport from './components/admin/report/lotteryprize/List.vue'
import MemberReport from './components/admin/report/member/List.vue'


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
		path:'/luckydraw',
		name: 'luckydraw',
		component:LuckyDraw
	},
	{
		path:'/kista',
		name: 'kista',
		component:Kista
	},
	{
		path:'/agent',
		component: Agent
	},
	
	{
		path:'/report',
		name: 'report',
		component:Report
	},
	{
		path:'/report/tpnp/:managerid',
		component: TpnpReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/tpnpl/:managerid',
		component: TpnplReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/agent/:managerid',
		component: AgentReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/purchase/:managerid',
		component: PurchaseReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/incomeexpenditure/:managerid',
		component: IncomeExpenditureReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/expenditure/:managerid',
		component: ExpenditureReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/record/:managerid',
		component: RecordReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/lotteryprize/:managerid',
		component: LotteryPrizeReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/member/:managerid',
		component: MemberReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/clientlist',
		component: ClientList
	},
	{
		path:'/bankbalance',
		component: BankBalance
	},
	{
		path:'/incomeexpenditurelist',
		component: IncomeExpenditureList
	},
	{
		path:'/record',
		component: Record
	},
	{
		path:'/purchase',
		component:Purchase
	},
	{
		path:'/overview',
		component:Overview
	},
	{
		path:'/overview/:managerid/viewall',
		component: Viewall
	},

]