import Vue from 'vue';
import Vuex from 'vuex';
import _ from 'underscore';
import createPersist, { createStorage } from 'vuex-localstorage'

Vue.use(Vuex);

export default new Vuex.Store({
	plugins: [createPersist({
			namespace: 'sessions-create-website',
			initialState: {},
			// ONE_WEEK 
			expires: 2 * 60 * 60 * 1e3
		})],
		state: {
			sessions: []
		},
		getters: {
			session(state) {
				return (address) => {
					return _.findWhere(state.sessions, {address: address});
				};
			}
		},
		mutations: {
			addSession(state, session) {
				let index = _.findIndex(state.sessions, {address: session.address});
				if (index !== -1) {
					state.sessions[index] = session;
				} else {
					state.sessions.push(session);
				}
			},
			removeSession(state, address) {
				let index = _.findIndex(state.sessions, {address: address});
				if (index !== -1) {
					state.sessions[index] = null;
				}
				state.sessions = _.without(state.sessions, null);
			}
		}
});
