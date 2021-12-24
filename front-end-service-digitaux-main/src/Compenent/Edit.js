import React,{Component} from 'react' ;
import axios from 'axios';
import { Form , Button  } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useState } from 'react';
import { Link } from 'react-router-dom';



class Edit extends Component {

   constructor(props) {
   super(props)

 this.state = {
   name:'',
   email:'',
  
  }
  this.onChange = this.onChange.bind(this)
    this.onSubmit = this.onSubmit.bind(this)
}
 componentDidMount(){
    const urlGetUser = "http://localhost/api/api/users/"+this.props.match.params.id;
        axios.get(urlGetUser)
        .then((response) => {
                this.setState({
                    name:response.data.name,
                    email:response.data.email
                })
        })
        .catch((error) => {
            alert(error.response.data.message)  
          console.log(error.response.status);
          console.log(error.response.headers);
        });
        console.log(this.state.name)
      }
  onChange(e){
    this.setState({
     [e.target.name]:e.target.value

    })

  }
  
onSubmit(e){
    e.preventDefault()
 const{name,email}=this.state;
        const urlUpdateUser = "http://localhost/api/api/users/"+this.props.match.params.id;

         axios.post(urlUpdateUser,JSON.stringify(this.state={name,email}))
         .then((response) => { alert(response.data.message)})
         .catch((error) => {
        if (error.response) {
          let x = error.response.data;
          JSON.parse(JSON.stringify(x));
          alert(x.Error)
          console.log(error.response.data);
                     }
         });
          

}
 
render(){
 
return(
  <>

  <Form className="d-grid gap-2 mt-5" onSubmit={this.onSubmit}>
 
  <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Control type="text" name="name" onChange={this.onChange} value={this.state.name}/>

       </Form.Group>

      <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Control type="email" name="email" onChange={this.onChange} value={this.state.email}/>

       </Form.Group>
<Button  variant="success" type="submit" >
  Edit user
</Button>

       </Form>
       <Link to="/session" >Go back to List of users</Link>
      </>

)
}
}
export default Edit;

