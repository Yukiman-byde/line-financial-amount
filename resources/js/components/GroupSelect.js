import React, {useState} from 'react';
import LaravelApi from './LaravelApi'
import styled from 'styled-components';
import {Link} from 'react-router-dom';
import Button from '@material-ui/core/Button';
import ButtonHeaderStyled from './ButtonHeaderStyled';

function GroupSelect({groups}){
    
    return(
        <div>
            <ButtonHeaderStyled title="グループを選んでください"/>
            {groups.map((group, index) => (
              <Button 
              style={{color: "white", backgroundColor: '#00B900', width: '100%', marginBottom: 20}}
              key={index}
              component={Link}
              to={`${group.name}`}
              variant="contained"
              >{ group.name }
              </Button>
            ))}
        </div>
        );
}

export default GroupSelect;



