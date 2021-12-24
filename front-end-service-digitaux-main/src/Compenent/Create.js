import React,{Component} from 'react' ;
import axios from 'axios';
import { Form , Button , Col } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import Header from '../Compenent/Header';
import { Link,Redirect } from 'react-router-dom';


class Create extends Component {

   constructor(props) {
   super(props)

 this.state = {
   name:'',
   email:'',
   password:'',
  
  }
  this.onChange = this.onChange.bind(this)
  this.SubmitForm = this.SubmitForm.bind(this)
}





  onChange(e){
    this.setState({
     [e.target.name]:e.target.value

    })

  }
  
  SubmitForm(e){
 e.preventDefault()
 const{name,email,password}=this.state;
if(email !==''){
     localStorage.setItem("token","data")
     localStorage.setItem("emailuser",email)
     const url = "http://localhost/api/api/users";
axios.post(url ,JSON.stringify(this.state={name,email,password})
).then(res => {
        alert(res.data.message);
        window.location.reload();
      }).catch(function (error) {
        if (error.response) {
          let x = error.response.data;
          JSON.parse(JSON.stringify(x));
          alert(x.Error)
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        }
      });


}

  }



 
render(){ 
return(
  <>

  <Form className="d-grid gap-2 mt-5" onSubmit={this.SubmitForm}>
 
  <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Control type="text" name="name" onChange={this.onChange} value={this.state.name}  placeholder="Enter Name" required />

       </Form.Group>

      <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Control type="email" name="email" onChange={this.onChange} value={this.state.email} placeholder="Enter email" required />

       </Form.Group>

       <Form.Group className="mb-3" controlId="formBasicPassword">
          <Form.Control type="password" name="password" onChange={this.onChange} value={this.state.password} placeholder="Password" required />
          </Form.Group>
<Button  variant="success" type="submit" >
  ADD user
</Button>

       </Form>
      </>

)
}
}
export default Create;

