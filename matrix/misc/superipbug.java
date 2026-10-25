// Decompiled by Jad v1.5.8e. Copyright 2001 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/kpdus/jad.html
// Decompiler options: packimports(3) 
// Source File Name:   get_env.java

import java.applet.Applet;
import java.awt.*;
import java.io.*;
import java.net.*;

public class get_env extends Applet
{

    public void init()
    {
        super.init();
        str = getParameter("MODE");
        String s = str == null ? "COMP_N" : str;
        i = Integer.parseInt(getParameter("WIDTH"));
        int j = i <= 0 ? 384 : i;
        i = Integer.parseInt(getParameter("HEIGHT"));
        int k = i <= 0 ? 16 : i;
        str = getParameter("HSPACE");
        i = str == null ? 0 : Integer.parseInt(str);
        int l = i <= 0 ? 0 : i;
        if(l > j / 2)
            l = j / 2;
        str = getParameter("VSPACE");
        i = str == null ? 0 : Integer.parseInt(str);
        int i1 = i <= 0 ? 0 : i;
        if(i1 > j / 2)
            l = k / 2;
        int j1 = 0;
        int k1 = 0;
        int l1 = 0;
        str = getParameter("text");
        if(str.indexOf("#") == 0)
        {
            sst = Integer.valueOf(str.substring(1, 3), 16).toString();
            k1 = Integer.parseInt(sst);
            sst = Integer.valueOf(str.substring(3, 5), 16).toString();
            j1 = Integer.parseInt(sst);
            sst = Integer.valueOf(str.substring(5, 7), 16).toString();
            l1 = Integer.parseInt(sst);
        }
        setForeground(new Color(k1, j1, l1));
        int i2 = 192;
        int j2 = 192;
        int k2 = 192;
        str = getParameter("bgcolor");
        if(str.indexOf("#") == 0)
        {
            sst = Integer.valueOf(str.substring(1, 3), 16).toString();
            i2 = Integer.parseInt(sst);
            sst = Integer.valueOf(str.substring(3, 5), 16).toString();
            j2 = Integer.parseInt(sst);
            sst = Integer.valueOf(str.substring(5, 7), 16).toString();
            k2 = Integer.parseInt(sst);
        }
        setBackground(new Color(i2, j2, k2));
        str = getParameter("ALIGN");
        String s1 = str == null ? "LEFT" : str;
        str = getParameter("FONT");
        String s2 = str == null ? "Dialog" : str;
        int l2 = 0;
        str = getParameter("STYLE");
        if(str != null)
        {
            if(str.indexOf("bold") >= 0)
                l2++;
            if(str.indexOf("italic") >= 0)
                l2 += 2;
        }
        int i3 = 14;
        str = getParameter("SIZE");
        if(str != null)
            i3 = Integer.parseInt(str);
        res = new String("");
        rhost = getCodeBase().getHost();
        cbase = getCodeBase().toString();
        if(s.equals("COMP_N"))
        {
            try
            {
                InetAddress inetaddress = InetAddress.getLocalHost();
                String s3 = inetaddress.getHostName();
                String s4 = inetaddress.getHostAddress();
                res = s3 + " [" + s4 + "]";
            }
            catch(UnknownHostException _ex) { }
            if(res.indexOf(" [") <= 0)
                res = "unknown";
        }
        if(s.equals("R_HOST_____"))
        {
            try
            {
                url = new URL(getCodeBase(), "rhost.cgi?R_HOST");
            }
            catch(MalformedURLException _ex) { }
            try
            {
                in = new DataInputStream(url.openStream());
                res = in.readLine();
            }
            catch(Exception _ex) { }
            if(res == null)
                res = "unknown r_host";
        }
        if(s.equals("R_HOST"))
        {
            InputStream inputstream = null;
            DataInputStream datainputstream = null;
            try
            {
                url = new URL(getCodeBase(), cgifile);
                inputstream = url.openStream();
                datainputstream = new DataInputStream(inputstream);
            }
            catch(MalformedURLException _ex) { }
            catch(IOException _ex) { }
            try
            {
                res = datainputstream.readLine();
                inputstream.close();
            }
            catch(IOException _ex) { }
            if(res.indexOf(" [") <= 0)
                res = "none";
        }
        if(s.equals("DOMAIN"))
        {
            Object obj = null;
            try
            {
                Socket socket = new Socket(rhost, 80);
                PrintStream printstream = new PrintStream(socket.getOutputStream());
                printstream.println("GET " + cbase + cgifile);
                in = new DataInputStream(socket.getInputStream());
                res = in.readLine();
                printstream.close();
                socket.close();
            }
            catch(Exception _ex) { }
            if(res.indexOf(" [") <= 0)
                res = "unknown";
        }
        setLayout(null);
        addNotify();
        byte byte0 = 0;
        if(s1.equals("CENTER"))
            byte0 = 1;
        if(s1.equals("RIGHT"))
            byte0 = 2;
        Label label = new Label(res, byte0);
        label.reshape(l, i1, j - l, k - i1);
        Font font = new Font(s2, l2, i3);
        label.setFont(font);
        add(label);
        System.out.println("get_env.class (ver1.0)");
        System.out.println("Copyright (C) 1997 Atelier AZUMA. All Rights Reserved.");
    }

    public get_env()
    {
        cgifile = "get_env.cgi";
    }

    public String text;
    public String bgcolor;
    public String sst;
    public String s_domain;
    public String res;
    public String dums;
    public String str;
    public String cbase;
    public String cgifile;
    URL url;
    DataInputStream in;
    String rhost;
    int i;
}
