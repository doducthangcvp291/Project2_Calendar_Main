<script>
import Fullcalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";
import datepicker from 'vue2-datepicker';
import datetime from 'vuejs-datetimepicker';
// import { logout } from '../helpers/auth';
//import { mapGetters } from "vuex";
export default {
  name: 'Calendar',
  components: {
    Fullcalendar,
    datepicker,
    datetime
  },
  data() {
    return {
      calendarPlugins: [dayGridPlugin,timeGridPlugin,interactionPlugin],
      headerToolbar: {
      left: 'prev,next,today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: "",
      newEvent: {
        event_name: "",
        start_date: "",
        end_date: ""
      },
      addingMode: true,
      indexToUpdate: "",
      start_time:"",
      end_time:"",
      test_timepicker:"",
      addEvent: {
        event_name : "",
        time_start_display : "",
        time_end_display: "",        
      }

    };
  },
  created() {
    this.getEvents();
  },
  //computed: mapGetters(['CURRENT_USER_ACCESS_TOKEN']),

  methods: {
    handleSelect(selectInfo){
      console.log('Select Info: ',selectInfo)
    },
    addNewEvent() {
      // this.addEvent.event_name = this.newEvent.event_name ;
      console.log("event before add: ",this.newEvent)
      axios
        .post("/api/calendar",{...this.newEvent },{ headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token } }, )
        .then(data => {
          console.log("data added : ",data);
          this.getEvents(); // update our list of events
          this.resetForm(); // clear newEvent properties (e.g. title, start_date and end_date)
        })
        .catch(err =>
          console.log("Unable to add new event!", err)
        );
    },
    showEvent(arg) {
      this.addingMode = false;
      let arg_id = +arg.event.id;
      console.log("arg event :", arg.event);
      const ObjTime = this.events.find(
        event => event.id === +arg_id
      );
      const { id, title, start, end } = ObjTime;
      const TestTimeObject = arg.event.start 
      const startTime = start.slice(11,16);
      // console.log("startTime ",startTime)
      if ( startTime.length > 1 ){
        this.start_time = startTime ;
      }
      this.indexToUpdate = id;
      this.newEvent = {
        event_name: title,
        // start_date: start.slice(0,10),
        // end_date: end.slice(0,10)
        start_date: start,
        end_date: end
      };
      this.addEvent.time_start_display = start.slice(0,10) ,
      this.addEvent.time_end_display = end.slice(0,10)
    },

    updateEvent() {
      // axios
      //   .put("/api/calendar/" + this.indexToUpdate, {
      //     ...this.newEvent
      //   },{ headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token} })
      //   .then(res => {
      //     console.log("updated: ",res);
      //     this.resetForm();
      //     this.getEvents();
      //     this.addingMode = !this.addingMode;
      //   })
      //   .catch(err =>
      //     console.log("Unable to update event!", err.response.data)
      //   );
        

        axios
        .post("/api/calendar",{...this.newEvent },{ headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token } }, )
        .then(data => {
          console.log("data added : ",data);
          this.getEvents(); // update our list of events
          this.resetForm(); // clear newEvent properties (e.g. title, start_date and end_date)
        })
        .catch(err =>
          console.log("Unable to add new event!", err)
        );
    },
    deleteEvent() {
      axios
        .delete("/api/calendar/" + this.indexToUpdate ,{ headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token } })
        .then(res => {
          console.log(" Res Delete: ", res);
          this.resetForm();
          this.getEvents();
          this.addingMode = !this.addingMode;
        })
        .catch(err =>
          console.log("Unable to delete event!", err.response.data)
        );
    },
    async getEvents() {
            try {
                const res = await axios.get("/api/calendar",{ headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token } })
                console.log(" Res getEvent: ",res)
                this.events = res.data.data ;                                     
            } catch (error) {
                //this.error = error.response.data
                console.log('getListEventError',error)
            }
        },
    // getEvents() {
    //   axios
    //     .get("/api/calendar",{ headers: { Authorization: this.$store.state.currentUser.token } })
    //     .then(resp => {
    //                     console.log(" Res getEvent: ",resp)
    //                     this.events = resp.data.data ;
    //                     })
    //     .catch(err => console.log(err.response.data));
    // },
    resetForm() {
      Object.keys(this.newEvent).forEach(key => {
        return (this.newEvent[key] = "");
      });
      console.log("done reset form")
    },
    testTimePicker() {
      console.log(" Time Picker: ",this.test_timepicker)
    },

    userLogOut() {//cho vao button log out //reset cleanstate VueX when login

        // logout(this.$store.state.Auth.currentUser.token)// ham login ben help/auth
        //     .then(res => {
        //         console.log("res after LOGOUT:  ",res);
        //         this.$router.push({path: '/login'}).catch(()=>{});
        //     })
        //     .catch(err => {
        //         console.log("error log out:  ", err);
        //     })

        axios
        .post('api/auth/logout', { headers: { Authorization: 'Bearer '+ this.$store.state.Auth.currentUser.token } }) // hoac header bearer token 
        .then(result => {
            console.log("result logout : ",result);
            this.$router.push({path: '/login'}).catch(()=>{});
        })
        .catch(err => {
            console.log("Error when logout: ",err);
        })

        this.$store.dispatch("LOGOUT");
    },
    
  },
  watch: {
    indexToUpdate() {
      return this.indexToUpdate;
    }
  }
};
</script>
<template>
<div>

  <div class="fixed">
      <nav class="top-bar" data-topbar role="navigation">
        <button type="button" class="button"  @click="userLogOut">Log out</button>
      </nav>
  </div>
  <div class="calendar-app">    
      <div class="calendar-app-sidebar">
        <form @submit.prevent class='calendar-app-sidebar-section'>
                  <div class="calendar-app-sidebar-section ">
                          <label for="event_name">Event Name</label>
                          <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name" required>
                  </div>
                <div class="calendar-app-sidebar-section">                  
                              <div class="calendar-app-sidebar-section-child col-md-6">
                                            <div class="form-group">
                                              <label for="start_date">Start Date</label>
                                              <!-- <input
                                                type="date"
                                                id="start_date"
                                                class="form-control"
                                                v-model="newEvent.start_date"
                                              > -->
                                                <datetime
                                                  id="start_date"
                                                  class="form-control" 
                                                  v-model="newEvent.start_date" 
                                                  format = "YYYY-MM-DD H:i:s" required                                                                                 
                                                />                          
                                            </div>                     

                              </div>
                        
                              <div class="calendar-app-sidebar-section-child col-md-6">
                                  <div class=" form-group">
                                    <label for="end_date">End Date</label>
                                    <!-- <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date"/> -->
                                        <datetime 
                                          id="end_date"
                                          class="form-control" 
                                          v-model="newEvent.end_date" 
                                          format = "YYYY-MM-DD H:i:s" required                                                                                 
                                        />
                                  </div>
                              </div>

                              <div class=" calendar-app-sidebar-section-child col-md-6 mb-4" v-if="addingMode">
                                <button class="btn btn-sm btn-primary" @click="addNewEvent">Save Event</button>
                                <label for="end_date">Test Start Time</label>
                                <datepicker 
                                        v-model="start_time" 
                                        lang="en"
                                        type="time"
                                        format="HH:mm " :minute-step="5"                            
                                />
                                <!-- <label for="end_date">Test Time Picker</label>
                                <datetime 
                                        v-model="test_timepicker" 
                                        format = "YYYY-MM-DD h:i:s"                                                                                  
                                /> -->
                                <button type="button" class="button"  @click="testTimePicker">ButtonTimePick</button>
                              </div>
                        
                                      
                        
                              <template v-else>
                                <div class="calendar-app-sidebar-section-child col-md-6 mb-4">
                                <label for="end_date">Test Start Time</label>
                                <!-- <input type="time" v-model="start_time">
                                 -->
                                 <datetime 
                                          id="start_time"
                                          class="form-control" 
                                          v-model="start_time" 
                                          format = "H:i:s"                                                                                 
                                        />
                                  <button class="btn btn-sm btn-success" @click="updateEvent">Update</button>
                                  <button class="btn btn-sm btn-danger" @click="deleteEvent">Delete</button>
                                  <button class="btn btn-sm btn-secondary" @click="addingMode = !addingMode">Cancel</button>
                                </div>
                              </template>
                </div>

        </form>
      </div>
      <div class="calendar-app-main">
        <Fullcalendar @eventClick="showEvent" :plugins="calendarPlugins" 
        :selectable="true" :header="headerToolbar" @select="handleSelect" :events="events"/>
      </div>
    
  </div>
</div>
</template>



<style lang="css">
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
@import "~@fullcalendar/timegrid/main.css";
@import "~vue2-datepicker/index.css";
/* .fc-title {
  color: #fff;
}
.fc-title:hover {
  cursor: pointer;
} */
.fc { /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}
.calendar-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}
.calendar-app-main {
  flex-grow: 1;
  padding: 3em;
}
.calendar-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}
.calendar-app-sidebar-section {
  padding: 2em;
}
.calendar-app-sidebar-section-child {
  height: 30px;
  /* width: 50%; */
}

</style>