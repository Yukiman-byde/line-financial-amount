import React from 'react';
import styled from 'styled-components';
import Paper from '@material-ui/core/Paper';
import { useSpring, animated } from '@react-spring/web';


function Home(){
    const styles = useSpring({
     from: {
      opacity: 0,
      transition: '1s',
      top: '60%',
     },
     to: {
      opacity: 1,
      top: '50%',
     }
    });
    return(
        <div>
          <HomePicture></HomePicture> 
          <HomeTitle style={styles}>ようこそ</HomeTitle>
        </div>
        );
}

export default Home

const HomePicture = styled('div')({
    position: 'relative',
    width: '100%',
    height: '100vh',
    background: 'rgb(0,185,0)',
    background: 'linear-gradient(180deg, rgba(0,185,0,1) 35%, rgba(255,255,255,0.9794292717086834) 100%)',
});

const HomeTitle = styled(animated.div)({
    position: 'absolute',
    textAlign: 'center',
    alignItems: 'center',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    zIndex: 999,
    backgroundColor: '#fff',
    color: '#00b900',
    padding: '30px',
    borderRadius: '20px',
});

const HomeBody = styled(Paper)({
    top: '-20px',
    alignItems: 'center',
    textAlign: 'center',
    height: '30vh',
    width: '100%',
    backgroundColor: '#fff',
    borderRadius: '20px',
    border: '1px, solid: gray'
});

const HomeFooter = styled('div')({
    background: 'rgb(0,185,0)',
    height: '30vh',
    width: '100%',
})