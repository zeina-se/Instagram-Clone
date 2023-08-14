import "./styles/App.css";
import "./styles/utilities.css";
import "./styles/colors.css";
import { BrowserRouter, Routes, Route, useLocation } from "react-router-dom";
import Authentication from "./pages/Authentication";
import { useEffect, useState } from "react";


function App() {
  return (
    <div className="App">
     <BrowserRouter>
        {/* <NavBar username={"Taha"} /> */}
        <Routes>
          <Route path="/" element={<Authentication />} />
          {/* <Route path="/posts" element={<posts />} /> */}
          {/* 
          <Route path="/profile" element={<Profile />} />
          <Route path="/singleView" element={<SingleView />} /> */}
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
