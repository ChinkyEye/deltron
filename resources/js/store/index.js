export default{
	state:{
		dashboard:[],
		manager:[],
		selectluckydraw:[],
		selectkista:[],
		selectagent:[],
		selectmanager:[],
		selectmluckydraw:[],
		detail:[],
		tpnpreport:[],
		tpnplreport:[],
		agentreport:[],
		purchasereport:[],
		incomeexpenditurereport:[],
		expenditurereport:[],
		recordreport:[],
		lotteryprizereport:[],
		reportdashboard:[],
		memberreport:[],
		luckydraw:[],
		kista:[],
		agent:[],
		clientlist:[],
		bankbalance:[],
		incomeexpenditure:[],
		record:[],
		purchase:[],

	},
	getters:{
		getDashboard(state){
			return state.dashboard
		},
		getManager(state){
			return state.manager
		},
		getSelectLuckyDraw(state){
			return state.selectluckydraw
		},
		getSelectMLuckyDraw(state){
			return state.selectmluckydraw
		},
		getSelectKista(state){
			return state.selectkista
		},
		getSelectAgent(state){
			return state.selectagent
		},
		getDetail(state){
			return state.detail
		},
		getSelectManager(state){
			return state.selectmanager
		},
		getTpnpReport(state){
			return state.tpnpreport
		},
		getTpnplReport(state){
			return state.tpnplreport
		},
		getAgentReport(state){
			return state.agentreport
		},
		getPurchaseReport(state){
			return state.purchasereport
		},
		getIncomeExpenditureReport(state){
			return state.incomeexpenditurereport
		},
		getExpenditureReport(state){
			return state.expenditurereport
		},
		getRecordReport(state){
			return state.recordreport
		},
		getLotteryPrizeReport(state){
			return state.lotteryprizereport
		},
		getReportDashboard(state){
			return state.reportdashboard
		},
		getMemberReport(state){
			return state.memberreport
		},
		getLuckyDraw(state){
			return state.luckydraw
		},
		getKista(state){
			return state.kista
		},
		getAgent(state){
			return state.agent
		},
		getClientList(state){
			return state.clientlist
		},
		getBankBalance(state){
			return state.bankbalance
		},
		getIncomeExpenditure(state){
			return state.incomeexpenditure
		},
		getRecord(state){
			return state.record
		},
		getPurchase(state){
			return state.purchase
		},
		
	},
	actions:{
		allDashboard(context){
			axios.get("/home/dashboard")
				.then((response)=>{
					// debugger;
					context.commit('dashboards', [response.data])
				})
		},
	
		allManager(context, params){
			axios.get("/home/manager?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('managers', [response.data.managers.data,response.data.pagination])
				})
		},
		allSelectLuckyDraw(context,params){
			axios.get("/home/luckydraw/select/getAllLuckyDraw"+"?managerid="+params[0])
				.then((response)=>{
					// console.log(response.data.selectluckdraws);
					context.commit('selectluckydraws', [response.data.selectluckdraws])
				})
		},
		allSelectMLuckyDraw(context, params){
			axios.get("/home/luckydraw/mselect/getAllMLuckyDraw"+"?managerid="+params[0])
				.then((response)=>{
					// console.log(response.data.selectluckdraws);
					context.commit('selectmluckydraws', [response.data.selectmluckdraws])
				})
		},
		allSelectKista(context, luckydraw_id){
			axios.get("/home/kista/select/getAllKista"+ (typeof luckydraw_id=="undefined"?"":"?luckydraw_id=" + luckydraw_id))
				.then((response)=>{
					context.commit('selectkistas', [response.data.selectkistas])
				})
		},
		allSelectAgent(context, manager_id){
			axios.get("/home/agent/select/getAllAgent"+ (typeof manager_id=="undefined"?"":"?manager_id=" + manager_id))
				.then((response)=>{
					context.commit('selectagents', [response.data.selectagents])
				})
		},
		allDetail(context, params){
			axios.get("/home/mdetail/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&agentid="+params[2]+"&managerid="+params[3])
				.then((response)=>{
					context.commit('details', [response.data])
				})
		},
		allSelectManager(context, params){
			axios.get("/home/manager/select/getAllManager")
			.then((response)=>{
				// console.log(response);
					context.commit('selectmanagers', [response.data.selectmanagers])
				})
		},
		allTpnpReport(context, params){
			axios.get("/home/report/tpnp/"+"?kistaid="+params[0]+"&luckydrawid="+params[1]+"&managerid="+params[2])
				.then((response)=>{
					context.commit('tpnpreports', [response.data.played,
												response.data.notplayed,
												response.data.playedamount,
												response.data.notplayamount,
												response.data.leave])
				})
		},
		allTpnplReport(context, params){
			axios.get("/home/report/tpnpl/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&type="+params[2]+"&page="+params[3]+"&managerid="+params[4])
				.then((response)=>{
					context.commit('tpnplreports', [response.data.tpnplreports.data,
													response.data.pagination,
													response.data.total,
													response.data.luckydraw_name,
													response.data.kista_name])
				})
		},
		allAgentReport(context, params){
			axios.get("/home/report/agent/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&agentid="+params[2]+"&type="+params[3]+"&page="+params[4]+"&managerid="+params[5])
				.then((response)=>{
					context.commit('agentreports', [response.data.agentreports.data,
													response.data.pagination,
													response.data.commisionamount,
													response.data.total,
													response.data.luckydraw_name,
													response.data.kista_name,
													response.data.agent_name,
													])
				})
		},
		allPurchaseReport(context, params){
			axios.get("/home/report/purchase/"+"?page="+params[0]+"&date1="+params[1]+"&date2="+params[2]+"&managerid="+params[3])
				.then((response)=>{
					context.commit('purchasereports', [response.data.purchasereports.data,
														response.data.pagination,
														response.data.totals,
														response.data.to_date,
														response.data.from_date])
				})	
		},
		allIncomeExpenditureReport(context, params){
			axios.get("/home/report/incomeexpenditure/"+"?page="+params[0]+"&kistaid="+params[1]+"&luckydrawid="+params[2]+"&date1="+params[3]+"&date2="+params[4]+"&managerid="+params[5])
				.then((response)=>{
					context.commit('incomeexpenditurereports', [response.data.incomeexpenditurereports_income.data,
																response.data.incomeexpenditurereports_expenditure.data,
																response.data.income_total,
																response.data.expenditure_total,
																response.data.bank_balance,
																response.data.bank_details,
																response.data.latest_income,
																response.data.opening_amount,
																response.data.luckydraw_name,
																response.data.kista_name,
																response.data.to_date,
																response.data.from_date])
				})	
		},
		allExpenditureReport(context, params){
			axios.get("/home/report/expenditure/"+"?page="+params[0]+"&luckydrawid="+params[1]+"&kistaid="+params[2]+"&expendituretype="+params[3]+"&managerid="+params[6])
				.then((response)=>{
					context.commit('expenditurereports',[response.data.expenditurereports.data,
														response.data.pagination,
														response.data.total,
														response.data.luckydraw_name,
														response.data.kista_name,
														response.data.expendituretype])
				})
		},
		allRecordReport(context, params){
			axios.get("/home/report/record/"+"?page="+params[0]+"&date1="+params[1]+"&date2="+params[2]+"&managerid="+params[3])
				.then((response)=>{
					context.commit('recordreports', [response.data.recordreports.data,
													response.data.pagination,
													response.data.totals,
													response.data.to_date,
													response.data.from_date])
				})
		},
		allLotteryPrizeReport(context, params){
			axios.get("/home/report/lotteryprize/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&search="+params[2]+"&page="+params[3]+"&managerid="+params[4])
				.then((response)=>{
					context.commit('lotteryprizereports', [response.data.lotteryprizereports.data,response.data.pagination,response.data.total])
				})
		},
		allReportDashboard(context, params){
			axios.get("/home/report/"+"?managerid="+params[0])
				.then((response)=>{
					context.commit('reportdashboards', [response.data])
				})
		},
		allMemberReport(context, params){
			axios.get("/home/report/member/"+"?luckydrawid="+params[0]+"&agentid="+params[1]+"&page="+params[2]+"&kistaid="+params[3]+"&managerid="+params[4])
				.then((response)=>{
					context.commit('memberreports', [response.data.memberreports.data,
													response.data.pagination,
													response.data.total,
													response.data.kista_name,
													response.data.count,
													response.data.luckydraw_name,
													response.data.agent_name,
													response.data.check,
													response.data.due_amount,
													response.data.collected_amount,
													response.data.commisionamount])
				})
		},
		allLuckyDraw(context, params){
			console.log(params);
			axios.get("/home/luckydraw?page="+params[0]+"&search="+params[1]+"&managerid="+params[2])
				.then((response)=>{
					context.commit('luckydraws', [response.data.luckydraws.data,response.data.pagination])
				})
		},
		allKista(context, params){
			axios.get("/home/kista?page="+params[0]+"&search="+params[1]+"&managerid="+params[2])
				.then((response)=>{
					context.commit('kistas', [response.data.kistas.data,response.data.pagination])
				})
		},
		allAgent(context, params){
			axios.get("/home/agent/"+"?page="+params[0]+"&search="+params[1]+"&managerid="+params[2])
				.then((response)=>{
					context.commit('agents', [response.data.agents.data,response.data.pagination])
				})
		},
		allClientList(context, params){
			axios.get("/home/clientlist/"+"?agent_id="+params[0]+"&page="+params[1]+"&managerid="+params[2])
				.then((response)=>{
					context.commit('clientlists', [response.data.clientlists.data,response.data.pagination])
				})
		},
		allBankBalance(context, params){
			axios.get("/home/bankbalance/"+"?page="+params[0]+"&managerid="+params[1])
				.then((response)=>{
					context.commit('bankbalances', [response.data.bankbalances.data,response.data.pagination])
				})
		},
		allIncomeExpenditure(context, params){
			axios.get("/home/incomeexpenditure/"+"?page="+params[0]+"&managerid="+params[1])
				.then((response)=>{
					context.commit('incomeexpenditures', [response.data.incomeexpenditures.data,response.data.pagination])
				})
		},
		allRecord(context, params){
			axios.get("/home/record/"+"?page="+params[0]+"&managerid="+params[1])
				.then((response)=>{
					context.commit('records', [response.data.records.data,response.data.pagination])
				})
		},
		allPurchase(context, params){
			axios.get("/home/purchase/"+"?page="+params[0]+"&managerid="+params[1])
				.then((response)=>{
					context.commit('purchases', [response.data.purchases.data,response.data.pagination])
				})
		},
		
	},
	mutations:{
		dashboards(state, payload){
			return state.dashboard = payload
		},
		managers(state, data){
			return state.manager = data
		},
		selectluckydraws(state, data){
			return state.selectluckydraw = data
		},
		selectmluckydraws(state, data){
			return state.selectmluckydraw = data
		},
		selectkistas(state, data){
			return state.selectkista = data
		},
		selectagents(state, data){
			return state.selectagent = data
		},
		details(state, data){
			return state.detail = data
		},
		selectmanagers(state, data){
			return state.selectmanager = data
		},
		tpnpreports(state, data){
			return state.tpnpreport = data
		},
		tpnplreports(state, data){
			return state.tpnplreport = data
		},
		agentreports(state, data){
			return state.agentreport = data
		},
		purchasereports(state, data){
			return state.purchasereport = data
		},
		incomeexpenditurereports(state, data){
			return state.incomeexpenditurereport = data
		},
		expenditurereports(state, data){
			return state.expenditurereport = data
		},
		recordreports(state, data){
			return state.recordreport = data
		},
		lotteryprizereports(state, data){
			return state.lotteryprizereport = data
		},
		reportdashboards(state, payload){
			return state.reportdashboard = payload
		},
		memberreports(state, data){
			return state.memberreport = data
		},
		luckydraws(state, data){
			return state.luckydraw = data
		},
		kistas(state, data){
			return state.kista = data
		},
		agents(state, data){
			return state.agent = data
		},
		clientlists(state, data){
			return state.clientlist = data
		},
		bankbalances(state, data){
			return state.bankbalance = data
		},
		incomeexpenditures(state, data){
			return state.incomeexpenditure = data
		},
		records(state, data){
			return state.record = data
		},
		purchases(state, data){
			return state.purchase = data
		},
		
	}
}