import React from 'react'
import axios from 'axios';
import { useEffect , useState } from 'react';
import { Link } from 'react-router-dom';

const ListUsers = () => {
    const [users, setUsers] = useState([]);
    const urlGetAllUsers = "http://localhost/api/api/users";
    const getUsers = async () => {
        axios.get(urlGetAllUsers)
        .then((response) => {
            setUsers(response.data);
        })
        .catch((error) => console.log(error.response));
        // console.log(users);
      };
      useEffect(() => {
        getUsers();
},[])

const  hundleDelete = (id) => {
  
  const urlDeleteUSer = "http://localhost/api/api/delete/"+id; 
  axios.get(urlDeleteUSer)
  .then((response) => {
    alert(response.data.message);
    window.location.reload();
  })
  .catch((error) => {
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


    return (
<>
    <table className="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Edit</th>
          <th>delete</th>
        </tr>
      </thead>
      <tbody>
      {users.map((user) => {
          const { id, name, email} = user;
          return (

        <tr key={id}>
        <td>
            <p>
                {name}
            </p>
        </td>
        <td>
            <p>
                {email}
            </p>
        </td>
        <td>
          <Link to={"/Edit/"+id}  className="btn">Edit</Link>   
          </td>
        <td name="delete">
          <button className="btn" onClick={() => hundleDelete(id)}>
                  Delete
                </button>
                </td>
        </tr>
          );
        })}






      </tbody>
      </table>


</>
    )
}

export default ListUsers
