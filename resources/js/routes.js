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
import LuckyDrawEdit from './components/admin/luckydraw/Edit.vue'

import Kista from './components/admin/kista/List.vue'
import KistaEdit from './components/admin/kista/Edit.vue'

import Agent from './components/admin/agent/List.vue'
import AgentEdit from './components/admin/agent/Edit.vue'

import ClientList from './components/admin/clientlist/List.vue'

import BankBalance from './components/admin/bankbalance/List.vue'
import BankBalanceEdit from './components/admin/bankbalance/Edit.vue'

import IncomeExpenditureList from './components/admin/incomeexpenditure/List.vue'
import IncomeExpenditureEdit from './components/admin/incomeexpenditure/Edit.vue'

import Record from './components/admin/record/List.vue'
import RecordEdit from './components/admin/record/Edit.vue'

import Purchase from './components/admin/purchase/List.vue'
import PurchaseEdit from './components/admin/purchase/Edit.vue'

import Overview from './components/admin/overview/List.vue'
import Viewall from './components/admin/overview/viewall.vue'
import Detail from './components/admin/detail/List.vue'
import AllDetail from './components/admin/detail/alldetail.vue'




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
		path:'/luckydraw/:managerid',
		name: 'luckydraw',
		component:LuckyDraw
	},
	{
		path:'/luckydraw/:luckydrawid/edit',
		component: LuckyDrawEdit
	},
	{
		path:'/kista/:managerid',
		name: 'kista',
		component:Kista
	},
	{
		path:'/kista/:kistaid/edit',
		component: KistaEdit
	},
	{
		path:'/agent/:managerid',
		component: Agent
	},
	{
		path:'/agent/:agentid/edit',
		component: AgentEdit
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
		path:'/clientlist/:managerid',
		component: ClientList
	},
	{
		path:'/bankbalance/:managerid',
		component: BankBalance
	},
	{
		path:'/bankbalance/:bankbalanceid/edit',
		component: BankBalanceEdit
	},

	{
		path:'/incomeexpenditurelist/:managerid',
		component: IncomeExpenditureList
	},
	{
		path:'/incomeexpenditure/:incomeexpenditureid/edit',
		component: IncomeExpenditureEdit
	},
	{
		path:'/record/:managerid',
		component: Record
	},
	{
		path:'/record/:recordid/edit',
		component: RecordEdit
	},

	{
		path:'/purchase/:managerid',
		component:Purchase
	},
	{
		path:'/purchase/:purchaseid/edit',
		component: PurchaseEdit
	},
	{
		path:'/overview',
		component:Overview
	},
	{
		path:'/overview/:managerid/viewall',
		component: Viewall
	},
	{
		path:'/detail',
		component:Detail
	},
	{
		path:'/detail/:managerid/alldetail',
		component: AllDetail
	},

]