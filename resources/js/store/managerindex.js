export default{
	state:{
		dashboard:[],
		luckydraw:[],
		selectluckydraw:[],
		selectkista:[],
		selectagent:[],
		kista:[],
		client:[],
		agent:[],
		subagent:[],
		agentcommision:[],
		detail:[],
		payment:[],
		kistadetail:[],
		remaining:[],
		expense:[],
		purchase:[],
		sale:[],
		incomeexpenditure:[],
		bankbalance:[],
		agenthaspaid:[],
		record:[],
		kistahasopening:[],
		clientlist:[],
		tpnpreport:[],
		tpnplreport:[],
		agentreport:[],
		expensereport:[],
		lotteryprizereport:[],
		purchasereport:[],
		incomeexpenditurereport:[],
		expenditurereport:[],
		recordreport:[],
		previewreport:[],
		memberreport:[],
		selectkistacommision:[],
		reportdashboard:[],
		booking:[],
		notusedserial:[],
		booking:[],
		
	},
	getters:{
		getDashboard(state){
			return state.dashboard
		},
		getLuckyDraw(state){
			return state.luckydraw
		},
		getSelectLuckyDraw(state){
			return state.selectluckydraw
		},
		getSelectKista(state){
			return state.selectkista
		},
		getSelectAgent(state){
			return state.selectagent
		},
		getKista(state){
			return state.kista
		},
		getClient(state){
			return state.client
		},
		getAgent(state){
			return state.agent
		},
		getSubAgent(state){
			return state.subagent
		},
		getAgentCommision(state){
			return state.agentcommision
		},
		getDetail(state){
			return state.detail
		},
		getPayment(state){
			return state.payment
		},
		getKistaDetail(state){
			return state.kistadetail
		},
		getRemaining(state){
			return state.remaining
		},
		getExpense(state){
			return state.expense
		},
		getPurchase(state){
			return state.purchase
		},
		getSale(state){
			return state.sale
		},
		getBankBalance(state){
			return state.bankbalance
		},
		getAgentHasPaid(state){
			return state.agenthaspaid
		},
		getIncomeExpenditure(state){
			return state.incomeexpenditure
		},
		getClientList(state){
			return state.clientlist
		},
		getRecord(state){
			return state.record
		},
		getKistaHasOpening(state){
			return state.kistahasopening
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
		getExpenseReport(state){
			return state.expensereport
		},
		getLotteryPrizeReport(state){
			return state.lotteryprizereport
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
		getPreviewReport(state){
			return state.previewreport
		},
		getMemberReport(state){
			return state.memberreport
		},
		getSelectKistaCommision(state){
			return state.selectkistacommision
		},
		getReportDashboard(state){
			return state.reportdashboard
		},
		getBooking(state){
			return state.booking
		}
		
	},
	actions:{
		allDashboard(context){
			axios.get("/home/dashboard")
				.then((response)=>{
					// debugger;
					context.commit('dashboards', [response.data])
				})
		},
		allLuckyDraw(context, params){
			axios.get("/manager/luckydraw?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					// console.log(response);
					context.commit('luckydraws', [response.data.luckydraws.data,response.data.pagination])
				})
		},
		allSelectLuckyDraw(context){
			axios.get("/manager/luckydraw/select/getAllLuckyDraw")
				.then((response)=>{
					// console.log(response.data.selectluckdraws);
					context.commit('selectluckydraws', [response.data.selectluckdraws])
				})
		},
		allSelectKista(context, luckydraw_id){
			// console.log(luckydraw_id);
			axios.get("/manager/kista/select/getAllKista"+ (typeof luckydraw_id=="undefined"?"":"?luckydraw_id=" + luckydraw_id))
				.then((response)=>{
					// console.log(response);
					context.commit('selectkistas', [response.data.selectkistas])
				})
		},
		allSelectAgent(context, kista_id){
			// console.log(kista_id);
			axios.get("/manager/agent/select/getAllAgent"+ (typeof kista_id=="undefined"?"":"?kista_id=" + kista_id))
				.then((response)=>{
					context.commit('selectagents', [response.data.selectagents])
				})
		},
		allKista(context, params){
			axios.get("/manager/kista?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('kistas', [response.data.kistas.data,response.data.pagination])
				})
		},
		allClient(context, params){
			axios.get("/manager/agent/add/client/"+params[2]+"?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					// console.log(response.data.agent_id);
					context.commit('clients', [response.data.clients.data,response.data.agent_id,response.data.pagination])
				})
		},
		allAgent(context, params){
			axios.get("/manager/agent/"+"?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					// console.log(response.data.agents.data);
					context.commit('agents', [response.data.agents.data,response.data.pagination])
				})
		},
		allSubAgent(context, params){
			// console.log(params);
			axios.get("/manager/subagent/"+params[2]+"?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('subagents', [response.data.subagents.data,response.data.pagination])
				})
		},
		allAgentCommision(context, params){
			axios.get("/manager/agent/commision")
				.then((response)=>{
					// console.log(response.data.agentcommisions);
					context.commit('agentcommisions', [response.data.agentcommisions])
				})
		},
		allDetail(context, params){
			axios.get("/manager/mdetail/"+"?agentid="+params[0]+"&kistaid="+params[1])
				.then((response)=>{
					context.commit('details', [response.data])
				})
		},
		allPayment(context, params){
			// console.log(params);
			axios.get("/manager/payment/"+"?agentid="+params[0]+"&kistaid="+params[1]+"&luckydrawid="+params[2])
				.then((response)=>{
					context.commit('payments', [response.data])
				})
		},
		allKistaDetail(context, params){
			axios.get("/manager/detail/"+"?agentid="+params[0]+"&kistaid="+params[1]+"&search="+params[2])
				.then((response)=>{
					// console.log(response.data.kistadetails);
					context.commit('kistadetails', [response.data.kistadetails])
				})
		},
		allRemaining(context, params){
			axios.get("/manager/remaining")
				.then((response)=>{
					context.commit('remainings', [response.data.remainings])
				})
		},
		allExpense(context, params){
			axios.get("/manager/expense/"+"?page="+params[0]+"&kistaid="+params[1])
				.then((response)=>{
					context.commit('expenses', [response.data.expenses.data,response.data.pagination])
				})
		},
		allPurchase(context, params){
			axios.get("/manager/purchase/"+"?page="+params[0])
				.then((response)=>{
					context.commit('purchases', [response.data.purchases.data,response.data.pagination])
				})
		},
		allSale(context, params){
			axios.get("/manager/expense/"+"?page="+params[0]+"&kistaid="+params[1])
				.then((response)=>{
					context.commit('sales', [response.data.sales.data,response.data.pagination])
				})
		},
		allBankBalance(context, params){
			axios.get("/manager/bankbalance/"+"?page="+params[0])
				.then((response)=>{
					context.commit('bankbalances', [response.data.bankbalances.data,response.data.pagination])
				})
		},
		allRecord(context, params){
			axios.get("/manager/record/"+"?page="+params[0])
				.then((response)=>{
					context.commit('records', [response.data.records.data,response.data.pagination])
				})
		},
		allIncomeExpenditure(context, params){
			axios.get("/manager/incomeexpenditure/"+"?page="+params[0])
				.then((response)=>{
					context.commit('incomeexpenditures', [response.data.incomeexpenditures.data,response.data.pagination])
				})
		},
		allAgentHasPaid(context, params){
			axios.get("/manager/agenthaspaid/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&agentid="+params[2])
				.then((response)=>{
					// console.log(response);
					// context.commit('agenthaspaids', [response.data])
					context.commit('agenthaspaids', [response.data.agenthaspaids,
													response.data.collected_amount,
													response.data.status])
				})
		},
		allKistaHasOpening(context, params){
			axios.get("/manager/kistahasopening/"+"?luckydrawid="+params[0]+"&kistaid="+params[1])
				.then((response)=>{
					// console.log(response);
					context.commit('kistahasopenings', [response.data])
				})
		},

		allClientList(context, params){
			axios.get("/manager/clientlist/"+"?agent_id="+params[0]+"&page="+params[1])
				.then((response)=>{
					context.commit('clientlists', [response.data.clientlists.data,response.data.pagination])
				})
		},
		allTpnpReport(context, params){
			axios.get("/manager/report/tpnp/"+"?kistaid="+params[0]+"&luckydrawid="+params[1])
				.then((response)=>{
					context.commit('tpnpreports', [response.data.played,
												response.data.notplayed,
												response.data.playedamount,
												response.data.notplayamount,
												response.data.leave])
				})
		},
		allTpnplReport(context, params){
			axios.get("/manager/report/tpnpl/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&type="+params[2])
				.then((response)=>{
					context.commit('tpnplreports', [response.data.tpnplreports.data,response.data.pagination,response.data.total])
				})
		},
		allAgentReport(context, params){
			axios.get("/manager/report/agent/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&agentid="+params[2]+"&type="+params[3])
				.then((response)=>{
					context.commit('agentreports', [response.data.agentreports.data,response.data.pagination,response.data.commisionamount])
				})
		},
		allExpenseReport(context, params){
			axios.get("/manager/report/expense/"+"?luckydrawid="+params[0])
				.then((response)=>{
					// console.log(response);
					// console.log(response.data.expensereports.data,response.data.pagination);
					context.commit('expensereports', [response.data.expensereports.data,response.data.pagination,response.data.totalamount,response.data.totalexpense])
				})
		},
		allLotteryPrizeReport(context, params){
			axios.get("/manager/report/lotteryprize/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&search="+params[2])
				.then((response)=>{
					context.commit('lotteryprizereports', [response.data.lotteryprizereports.data,response.data.pagination,response.data.total])
				})
		},
		allPurchaseReport(context, params){
			axios.get("/manager/report/purchase/"+"?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					context.commit('purchasereports', [response.data.purchasereports.data,response.data.pagination,response.data.totals])
				})	
		},
		allIncomeExpenditureReport(context, params){
			axios.get("/manager/report/incomeexpenditure/"+"?page="+params[0]+"&kistaid="+params[1]+"&luckydrawid="+params[2]+"&date1="+params[3]+"&date2="+params[4])
				.then((response)=>{
					// console.log(response);
					context.commit('incomeexpenditurereports', [response.data.incomeexpenditurereports_income.data,
																response.data.incomeexpenditurereports_expenditure.data,
																response.data.income_total,
																response.data.expenditure_total,
																response.data.bank_balance,
																response.data.bank_details,
																response.data.latest_income,
																response.data.opening_amount])
				})	
		},
		// allIncomeExpenditureReport(context, params){
		// 	// console.log(params);
		// 	axios.get("/manager/report/incomeexpenditure/"+"?page="+params[0]+"&kistaid="+params[1]+"&luckydrawid="+params[2]+"&date1="+params[3]+"&date2="+params[4])
		// 		.then((response)=>{
		// 			// console.log(response.data.prev_income);
		// 			context.commit('incomeexpenditurereports', [response.data.incomeexpenditurereports_income.data,
		// 														response.data.incomeexpenditurereports_expenditure.data,
		// 														response.data.income_total,
		// 														response.data.expenditure_total,
		// 														response.data.pagination,
		// 														response.data.totals,
		// 														response.data.bank_balance,
		// 														response.data.bank_details,
		// 														response.data.cash_balance,
		// 														response.data.opening_amount,
		// 														response.data.prev_income,
		// 														response.data.latest_income,
		// 														response.data.pre_opening_amount])
		// 		})	
		// },
		allExpenditureReport(context, params){
			axios.get("/manager/report/expenditure/"+"?page="+params[0]+"&luckydrawid="+params[1]+"&kistaid="+params[2]+"&expendituretype="+params[3])
				.then((response)=>{
					context.commit('expenditurereports',[response.data.expenditurereports.data,
														response.data.pagination,
														response.data.total])
				})
		},
		allRecordReport(context, params){
			axios.get("/manager/report/record/"+"?page="+params[0]+"&date1="+params[1]+"&date2="+params[2])
				.then((response)=>{
					context.commit('recordreports', [response.data.recordreports.data,response.data.pagination,response.data.totals])
				})
		},
		allPreviewReport(context, params){
			axios.get("/manager/report/preview/"+"?page="+params[0]+"&agentid="+params[1]+"&search="+params[2])
				.then((response)=>{
					// console.log(response.data.booking_array);
					context.commit('previewreports', [response.data.previewreports.data,
													response.data.pagination,
													response.data.total,
													response.data.array,
													response.data.booking_array])
				})
		},
		allMemberReport(context, params){
			axios.get("/manager/report/member/"+"?luckydrawid="+params[0]+"&agentid="+params[1])
				.then((response)=>{
					context.commit('memberreports', [response.data.memberreports.data,
													response.data.pagination,
													response.data.total,
													response.data.kista_name,
													response.data.check])
				})
		},
		allSelectKistaCommision(context, params){
			axios.get("/manager/kista/select/getAllKistaCommision"+"?luckydrawid="+params[0]+"&agentid="+params[1])
				.then((response)=>{
					// console.log(response.data.agent_it);
					context.commit('selectkistacommisions', [response.data.selectkistacommisions,response.data.agent_id])
				})
		},
		allReportDashboard(context){
			axios.get("/manager/report")
				.then((response)=>{
					// console.log(response);
					context.commit('reportdashboards', [response.data])
				})
		},
		allBooking(context, params){
			axios.get("/manager/booking")
				.then((response)=>{
					// console.log(response.data.bookings);
					context.commit('bookings', [response.data.bookings.data,response.data.pagination])
				})
		}
	},
	mutations:{
		dashboards(state, payload){
			return state.dashboard = payload
		},
		luckydraws(state, data){
			return state.luckydraw = data
		},
		selectluckydraws(state, data){
			return state.selectluckydraw = data
		},
		selectkistas(state, data){
			return state.selectkista = data
		},
		selectagents(state, data){
			return state.selectagent = data
		},
		kistas(state, data){
			return state.kista = data
		},
		clients(state, data){
			return state.client = data
		},
		agents(state, data){
			return state.agent = data
		},
		subagents(state, data){
			return state.subagent = data
		},
		details(state, data){
			return state.detail = data
		},
		payments(state, data){
			return state.payment = data
		},
		kistadetails(state, data){
			return state.kistadetail = data
		},
		remainings(state, data){
			return state.remaining = data
		},
		clientlists(state, data){
			return state.clientlist = data
		},
		agentcommisions(state,data){
			return state.agentcommision = data
		},
		expenses(state, data){
			return state.expense = data
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
		expensereports(state, data){
			return state.expensereport = data
		},
		lotteryprizereports(state, data){
			return state.lotteryprizereport = data
		},
		purchasereports(state, data){
			return state.purchasereport = data
		},
		purchases(state, data){
			return state.purchase = data
		},
		sales(state, data){
			return state.sale = data
		},
		bankbalances(state, data){
			return state.bankbalance = data
		},
		incomeexpenditures(state, data){
			return state.incomeexpenditure = data
		},
		incomeexpenditurereports(state, data){
			return state.incomeexpenditurereport = data
		},
		expenditurereports(state, data){
			return state.expenditurereport = data
		},
		agenthaspaids(state, data){
			return state.agenthaspaid = data
		},
		records(state, data){
			return state.record = data
		},
		recordreports(state, data){
			return state.recordreport = data
		},
		previewreports(state, data){
			return state.previewreport = data
		},
		kistahasopenings(state, data){
			return state.kistahasopening = data
		},
		memberreports(state, data){
			return state.memberreport = data
		},
		selectkistacommisions(state, data){
			return state.selectkistacommision = data
		},
		reportdashboards(state, payload){
			return state.reportdashboard = payload
		},
		bookings(state, data){
			return state.booking = data
		}
		
	}
}