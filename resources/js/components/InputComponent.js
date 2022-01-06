import React,{ useState, useEffect } from 'react';
import TextField from '@material-ui/core/TextField';
import LaravelApi from './LaravelApi';
import Button from '@material-ui/core/Button';
import RedirectToHome from './RedirectToHome';
import {useParams} from 'react-router-dom';
import styled from 'styled-components';


function InputComponent({user}){
      const [input, setInput] = useState(false);
      const [value, setValue] = useState('');
      const [number, setNumber] = useState(0);
      const [count, setCount] = useState(0);
      const {groupName} = useParams();
      
      const HandleClick = () => {
        if(number <= 0){
          window.alert('金額を入れてください');
          return null
        }else {
          console.log(number);
          setInput(true);
        }
      }
      
      const HandleInput = () => {
        setCount( c => c + 1 );
        if( count < 1 ) {
          const requests = {
            amount: number,
            borrow_provider_user_id: user,
            content: value,
            groupName: groupName,
          }
        
          LaravelApi.post('/calculate', requests).then((response) => {
           if(response.status === 200){
             return (
               <PaperStyled>
               
               </PaperStyled>
               );
           }
          }).catch(error => {
            confirm(error.message);
          });
          //returnで入力しましたを表示
          //componentで作ってimport
          //homeへ戻る
        }else {
          alert('クリックは一回までにしてください');
        }
      }
      
        return(
          <div>
                <div style={{display: 'flex'}}>
                  <TextField
                    style={{margin: 5}}
                    label="Read Only"
                    defaultValue={user}
                    InputProps={{
                      readOnly: true,
                    }}
                    variant="outlined"
                  />
                  <TextField
                  　onChange={(e)=>setNumber(e.target.value)}
                    style={{margin: 5}}
                    label="Amount"
                    type="number"
                    variant="outlined"
                  />
                </div>
                <Button
               style={{color: "white", backgroundColor: '#00B900', marginBottom: 16, width: '100%'}}
               onClick={HandleClick}
               >設定する</Button>
            {input ?
              <div style={{width: '100%'}}>
                <h3
                style={{color: '#00B900'}}
                >詳細を記述できます。</h3>
                  <TextField 
                    style={{width: "100%"}}
                    label="Multiline Placeholder"
                    placeholder="Placeholder"
                    value={value}
                    onChange={(e) => setValue(e.target.value)}
                    multiline
                    variant="outlined"
                  />
                  <Button
                   style={{color: "white", backgroundColor: '#00B900', marginTop: 16, marginBottom: 20, width: '100%'}}
                    onClick={ HandleInput }
                    >
                   設定する
                   </Button>
              </div>
             :<div></div>    
            }
          </div>
            );
    }
    
    export default InputComponent;
    
    const PaperStyled = styled('div')({
      backgroundColor: '#fff',
      width: '80%',
      height: '40vh',
    });