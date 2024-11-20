<template>
  <div class="welcome rad-15 p-relative c-fff overHidden">
    <header class="p-relative c-fff space-between">
      <h2 class="text-center">Learn Technology</h2>
        <ul class="d-flex">
          <li @click="changeTo('home')">
            <a class="font-bold c-fff">Home</a>
          </li>
          <li @click="changeTo('courses')">
            <a class="font-bold c-fff">Courses</a>
          </li>
          <li @click="changeTo('about')">
            <a class="font-bold c-fff">About</a>
          </li>
          <li @click="changeTo('contact')">
            <a class="font-bold c-fff">Contact</a>
          </li>
        </ul>
    </header>
    <div class="dynamic w-full" ref="change">
      <content class="home p-relative d-block m-auto text-center">
        <h1>Welcome To Our Learn Technology</h1>
        <p>
          Learn Technology Contain to all programming courses and too have roadmaps to all tracks,
          sign up now and choose your roadmap to can u work as developer or any think and get money
        </p>
        <a class="rad-6 lognow font-bold" @click="changeTo('login')">Login Now</a>
      </content>
      <content class="courses p-relative d-block m-auto text-center hide wrap">
        <div class="course rad-6" v-for="course in courses">
          <img :src="`/photos/${course.image}`" alt="Image Course" class="rad-6 w-full">
          <span :style="{color: course.color}" class="d-block font-bold">{{ course.name }}</span>
          <button @click="changeTo('login')" class="c-fff font-bold">Subscribe</button>
        </div>
        <button @click="changeTo('login')" class="more c-fff rad-6 font-bold p-absolute">More</button>
      </content>
      <content class="about p-relative d-block m-auto text-center hide betweenAndCenter">
        <about class="text d-grid">
          <span class="p-absolute font-bold">How It Start</span>
          <h2>Our Dream is Global Learning Programming</h2>
          <p>
            if u want learn programming to be developer, 
            in learn technology we offer you many tracks with good roadmap to can be professional, 
            we offer courses in all tracks, 
            to start learn first step register a new account and login with him, 
            choose your track and walk on roadmap we offer it for u
          </p>
        </about>
        <rate class="rate d-grid wrap">
          <img src="../img/prog.jpg" alt="Technology" class="rad-6 w-full">
          <div class="rates d-flex wrap">
            <div class="CountUsers rad-6 text-left">
              <span class="font-bold">4M</span>
              <p>count of users</p>
            </div>
            <div class="CountRoadmaps rad-6 text-left">
              <span class="font-bold">50</span>
              <p>count of roadmap</p>
            </div>
            <div class="CountCourses rad-6 text-left">
              <span class="font-bold">247</span>
              <p>count of courses</p>
            </div>
            <div class="CountUsersEnd rad-6 text-left">
              <span class="font-bold">145K</span>
              <p>count users end track</p>
            </div>
          </div>
        </rate>
      </content>
      <content class="contact p-relative d-block m-auto text-center hide betweenAndCenter">
        <info class='info d-block'>
          <h1 class="w-full">Contact Us</h1>
          <p>
            Learn Technology Welcome To Any Problem, we happy to help u in your problem and thanks for your service to know we
          </p>
        </info>
        <us class="us d-block space-between wrap">
          <h3>Call Us in each number or page</h3>
          <div class="phone align-center text-left">
            <p class="c-fff">Phone: </p>
            <div class="nums d-block">
              <p class="c-fff" v-for="num in contact.phone"> {{ num }} </p>
            </div>
          </div>
          <div class="address text-left">
            <p v-for="title in contact.title">Title: {{ title }}</p>
          </div>
          <div class="web text-left" v-for="web in contact.social">
            <p>{{ web.name }}: <a :href="web.url">Here</a></p>
          </div>
        </us>
      </content>
      <content class="login p-relative d-block m-auto text-center hide">
        <h1>Login Page</h1>
        <div class="box rad-6 m-auto">
          <form method="POST" @submit.prevent="loginAccount">
            <input type="email" v-model="login.email" ref="emailUser" name="email" placeholder="Your Email" required>
            <input type="password" v-model="login.pass" ref="passUser" name="password" placeholder="Your Password" required>
            <input type="submit" value="Login">
          </form>
          <p v-if="login.response.bool === 0" style="background-color: rgb(180 86 86)" class="resR">
            {{ login.response.message }}
          </p>
          <p v-if="login.response.bool === 1" style="background-color: rgb(86 179 180)" class="resR">
            {{ login.response.message }}
          </p>
          <div class="links space-between">
            <a @click="changeTo('register')">Register a new account</a>
            <a @click="changeTo('home')">Go to home</a>
          </div>
        </div>
      </content>
      <content class="register p-relative d-block m-auto text-center hide">
        <h1>Register new account</h1>
        <div class="box rad-6 m-auto">
          <form @submit.prevent="registerAccount">
            <input type="text" v-model="register.Fname" ref="fname" placeholder="Your First Name" required>
            <input type="text" v-model="register.Lname" ref="lname" placeholder="Your Last Name" required>
            <input type="email" v-model="register.email" ref="emailR" placeholder="Your Email" required>
            <input type="password" v-model="register.password" ref="passR" placeholder="Your Password" required>
            <input type="text" v-model="register.phone" ref="phone" placeholder="Your Phone" required>
            <input type="submit" value="register">
          </form>
          <p v-if="register.response.bool === 0" style="background-color: rgb(180 86 86)" class="resR">
            {{ register.response.message }}
          </p>
          <p v-if="register.response.bool === 1" style="background-color: rgb(86 179 180)" class="resR">
            {{ register.response.message }}
          </p>
          <div class="links space-between">
            <a @click="changeTo('login')">I have account</a>
            <a @click="changeTo('home')">Go to home</a>
          </div>
        </div>
      </content>
    </div>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  name: 'IndexPage',
  data(){
    return {
      stat: 'home',
      contact: {},
      courses: null,
      register: {
        Fname: '',
        Lname: '',
        email: '',
        password: '',
        phone: '',
        response: {
          bool: null,
          message: '',
        }
      },
      login: {
        email: '',
        pass: '',
        response: {
          bool: null,
          message: '',
        }
      }
    };
  },
  methods: {
    changeTo(name) {
      if (name !== this.stat) {
        let changing = this.$refs.change;
        changing.style.position = 'absolute';
        setTimeout( () => changing.style.left = '100%', 200);
        let content = changing.querySelector('.' + this.stat);
        setTimeout(() => {
          content.style.display = 'none';
          changing.style.left = '0';
          this.stat = name;
        },400);
        let newContent = changing.querySelector('.' + name);
        setTimeout(() => newContent.style.display = name !== 'home' ? 'flex' : 'block',450);
      }
    },
    async getDetails() {
      let res = await axios.get('/API/details')
      .catch(error => console.error(error));
      this.contact = res.data.contact;
    },
    async getCourses() {
      await axios.get('/API/Welcome/Courses')
      .then (response => this.courses = response.data)
      .catch (error => console.error(error));
    },
    registerAccount() {
      let register = this.register;
      if (register.Fname !== '' && register.Lname !== '' && register.email !== '' && register.password !== '' && register.phone !== ''){
        if (this.matchData(register.Fname, 'varchar')) {
          if (this.matchData(register.Lname, 'varchar')) {
            if (this.matchData(register.email, 'email')) {
              if (this.matchData(register.password,'pass')) {
                if (this.matchData(register.phone, 'phone')) {
                  axios.post('/server/register',{
                    account: this.register
                  },{
                    headers: {
                      'X-CSRF-TOKEN': window.token.csrftoken
                    }
                  })
                  .then (response => {
                    register.response = {
                      bool: 1,
                      message: "Registration successful!"
                    }
                    window.location.href = '/Courses';
                    window.history.replaceState(null, '', '/Courses')
                  })
                  .catch (err => {
                    register.response = {
                      bool: 0,
                      message: "Registration failed: This Is email or phone is already exists"
                    }
                  });
                } else {
                  this.wrongValue(this.$refs.phone,"Not a number");
                }
              } else {
                this.wrongValue(this.$refs.passR,"Allow numbers or letters only");
              }
            } else {
              this.wrongValue(this.$refs.email,"Enter real email");
            }
          } else {
            this.wrongValue(this.$refs.lname,"Enter your real name");
          }
        } else {
          this.wrongValue(this.$refs.fname,"Enter your real name");
        }
      }
    },
    loginAccount() {
      let login = this.login;
      if (login.email !== '' && login.pass !== '') {
        if (this.matchData(login.email, 'email')) {
          if (this.matchData(login.pass, 'pass')) {
            axios.post('/server/login',{
              account: this.login
            },{
              headers: {
                'X-CSRF-TOKEN': window.token.csrftoken
              }
            })
            .then(response => {
              login.response = {
                bool: 1,
                message: "Welcome " + response.data.message
              }
              window.location.href = '/Courses';
              window.history.replaceState(null, '', '/Courses')
            })
            .catch (err => {
              login.response = {
                bool: 0,
                message: "Not Found"
              }
            })
          } else {
            this.wrongValue(this.$refs.passUser, "Allow numbers or letters only");
          }
        } else {
          this.wrongValue(this.$refs.emailUser, "This Not Email");
        }
      }
    },
    matchData(value,bool) {
      let varchar = /^[A-Za-z]{3,}$/ig;
      let email = /^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/ig;
      let str = /^\w{10,}$/ig;
      let phone = /^\d{11}$/ig;
      
      if (bool === 'varchar') return varchar.test(value);
      if (bool === 'email') return email.test(value);
      if (bool === 'pass') return str.test(value);
      if (bool === 'phone') return phone.test(value);
    },
    wrongValue(element,err) {
      element.style.backgroundColor = "rgb(193 152 152)";
      element.value = '';
      element.placeholder = err;
      element.addEventListener('input', () => element.style.backgroundColor = 'rgba(247, 247, 247, 0.6705882353)');
    },
  },
  mounted () {
    this.getDetails();
    this.getCourses();
  },
};
</script>

<style lang="scss">
body {
  background-color: #a6defd;
  .welcome {
    margin: 60px;
    padding: 5px 10px;
    background-image: url('../img/welcome.jpg');
    background-size: cover;
    height: calc(86vh - 20px);
    header {
      h2 {
        padding-left: 40px;
        @media (max-width: 768px) {
          padding-left: 20px;
        }
      }
      ul {
        padding-right: 40px;
        li {
          padding: 5px 30px;
          @media (max-width: 991px) {
            padding: 5px 20px;
          }
          @media (max-width: 876px) {
            padding: 5px 10px;
          }
        }
        @media (max-width: 768px) {
          padding-right: 20px;
          justify-content: center;
        }
        li:hover {
          a {
            color: var(--color-bar-hover);
          }
        }
      }
      @media (max-width: 768px) {
        display: block;
      }
    }
    @media (max-width: 467px) {
      margin: 30px;
    }
    content {
      width: 80%;
      h1 {
        margin-top: 80px;
      }
      p {
        color: var(--color-parag);
      }
      .lognow {
        position: absolute;
        background-color: var(--color-button);
        bottom: -70px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 35px;
      }
      .lognow:hover {
        background-color: var(--color-button-hover);
      }
    }
    .dynamic {
      left: 0;
      transition: var(--trans);
      height: calc(100% - 125px);
      @media (max-width: 991px) {
        overflow: auto;
      }
      .contact {
        margin-top: 40px;
        gap: 100px;
        @media (max-width: 991px) {
          flex-direction: column;
          gap: 0;
        }
        @media (max-width: 991px) {
          margin-top: 0;
        }
        .us {
          .phone {
            gap: 10px;
            p {
              padding: 5px 0;
              margin: 0;
            }
          }
          div {
            width: 100%;
            @media (max-width: 991px) {
              display: flex;
              text-align: left;
            }
            @media (max-width: 768px) {
              width: fit-content;
            }
            .nums {
              p {
                min-width: 50%;
              }
            }
          }
        }
        a {
          color: var(--color-link);
        }
      }
      .about {
        @media (max-width: 991px) {
          gap: 50px;
          justify-content: center;
          flex-direction: column;
        }
        @media (max-width: 991px) {
          gap: 20px;
        }
        .text,.rate {
          margin-top: 30px;
        }
        .text {
          grid-template-rows: repeat(auto-fill,minmax(300px,1fr));
          width: calc(50% - 50px);
          @media (max-width: 991px) {
            display: flex;
            flex-direction: column;
            width: 80%;
          }
          span {
            color: #bb0c0c;
            left: 10px;
            top: 10px;
          }
        }
        .rate {
          width: calc(50% - 50px);
          grid-template-rows: repeat(auto-fill,minmax(100px, 1fr));
          @media (max-width: 991px) {
            width: 80%;
          }
          img {
            height: calc(100% - 25px);
            height: 140px;
            @media (max-width: 991px) {
              display: none;
            }
          }
          .rates {
            margin-top: 10px;
            gap: 10px;
            div {
              width: calc(50% - 5px);
              background-color: var(--back-rate-color);
              padding: 5px 10px;
              @media (max-width: 768px) {
                width: calc(25% - 8px);
              }
              @media (max-width: 676px) {
                display: none;
              }
              span {
                color: var(--orange-color);
              }
            }
          }
        }
      }
      .courses {
        gap: 10px;
        justify-content: space-between;
        div {
          width: calc(25% - 10px);
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); 
          img {
            height: 170px;
            margin-bottom: 5px;
          }
          span {
            font-size: 15px;
            margin-bottom: 5px;
          }
          button {
            background-color: var(--color-button);
            border: none;
            padding: 5px 13px;
            margin-bottom: 15px;
            cursor: pointer;
          }
          button:hover {
            background-color: var(--color-button-hover);
          }
          @media (max-width: 991px) {
            width: calc(50% - 10px)
          }
          @media (max-width: 768px) {
            width: 100%;
          }
        }
        .more {
          bottom: -60%;
          left: 50%;
          transform: translateX(-50%);
          padding: 10px 30px;
          border: none;
          background-color: var(--color-button);
          cursor: pointer;
        }
        .more:hover {
          background-color: var(--color-button-hover);
        }
      }
      .login,.register{
        justify-content: center;
        flex-direction: column;
        h1 {
          margin: 20px;
        }
        .box {
          background-color: #0000008a;
          width: 60%;
          padding: 20px;
          input:not(:last-child) {
            width: 100%;
            border-radius: 6px;
            border: none;
            outline: none;
            padding: 6px;
            background-color: #f7f7f7ab;
            margin-bottom: 15px;
            text-align: center;
          }
          input:last-child {
            background-color: var(--color-button);
            border: none;
            padding: 10px 40px;
            border-radius: 6px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
          }
          input:last-child:hover {
            background-color: var(--color-button-hover);
          }
          .links {
            margin-top: 15px;
            a {
              color: rgb(0 134 255);
              padding-right: 5px;
            }
          }
          @media (max-width: 991px) {
            width: 80%
          }
          @media (max-width: 678px) {
            width: 90%
          }
        }
        .resR {
          padding: 10px;
          border: 1px solid;
          font-size: 17px;
          font-weight: bold;
        }
      }
    }
  }
}
</style>