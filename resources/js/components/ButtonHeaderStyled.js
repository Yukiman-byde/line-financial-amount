import React from 'react';
import styled from 'styled-components';

function ButtonHeaderStyled({title}){
return(
        <HeaderStyled>
            <h3 style={{color:'#00B900'}}>{title}</h3>
        </HeaderStyled>
    );
}

export default ButtonHeaderStyled;

const HeaderStyled = styled('div')({
    width: '100%',
    height: '40vh',
    textAlign: 'center',
    alignItems: 'center',
    display: 'flex',
    justifyContent: 'center',
});
       