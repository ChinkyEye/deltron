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
	
		allManager(context, params){
			axios.get("/home/manager?page="+params[0]+"&search="+params[1])
				.then((response)=>{
					context.commit('managers', [response.data.managers.data,response.data.pagination])
				})
		},
		allSelectLuckyDraw(context){
			axios.get("/home/luckydraw/select/getAllLuckyDraw")
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
		allSelectAgent(context, kista_id){
			axios.get("/home/agent/select/getAllAgent"+ (typeof kista_id=="undefined"?"":"?kista_id=" + kista_id))
				.then((response)=>{
					context.commit('selectagents', [response.data.selectagents])
				})
		},
		allDetail(context, params){
			axios.get("/home/mdetail/"+"?luckydrawid="+params[0]+"&kistaid="+params[1]+"&agentid="+params[2])
				.then((response)=>{
					console.log(response);
					context.commit('details', [response.data])
				})
		},
		allSelectManager(context, params){
			axios.get("/home/manager/select/getAllManager")
			.then((response)=>{
				// console.log(response);
					context.commit('selectmanagers', [response.data.selectmanagers])
				})
		}


		
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
		}
		
	}
}