import java.io.*;
import java.lang.*;
import java.security.*;
import java.security.interfaces.*;
import java.math.*;
import cryptix.util.core.BI;
import cryptix.util.core.Hex;
import cryptix.provider.key.*;
import cryptix.provider.md.*;

class pgp_dsa_flaw {

    public static void main(String[] args) {

	try {
		BigInteger p, q, g, y, x, r, s, kk, z;
		BigInteger pprime, gprime, pstore, gstore;
		String w;

		FileOutputStream outFile = new FileOutputStream("Flaw.out");
		          PrintStream output = new PrintStream(outFile);

		g = new BigInteger("f7e1a085d69b3ddecbbcab5c36b857b97994afbbfa3aea82f9574c0b3d0782675159578ebad4594fe67107108180b449167123e84c281613b7cf09328cc8a6e13c167a8b547c8d28e0a3ae1e2bb3a675916ea37f0bfa213562f1fb627a01243bcca4f1bea8519089a883dfe15ae59f06928b665e807b552564014c3bfecf492a",16);
		w = cryptix.util.core.BI.dumpString(g);
		output.println("g = " + w);
		gstore = g;

		q = new BigInteger("9760508f15230bccb292b982a2eb840bf0581cf5", 16);
		w = cryptix.util.core.BI.dumpString(q);
		output.println("q = " + w);

		p = new BigInteger("fd7f53811d75122952df4a9c2eece4e7f611b7523cef4400c31e3f80b6512669455d402251fb593d8d58fabfc5f5ba30f6cb9b556cd7813b801d346ff26660b76b9950a5a49f9fe8047b1022c24fbba9d7feb7c61bf83b57e7c6a8a6150f04fb83f6d3c51ec3023554135a169132f675f3ae2b61d72aeff22203199dd14801c7",16);
		w = cryptix.util.core.BI.dumpString(p);
		output.println("p = " + w);
		pstore = p;

		pprime = new BigInteger("5380000000000000000000000000000000000001",16);                 
		w = cryptix.util.core.BI.dumpString(pprime);
		output.println("pprime = " + w);

		gprime = new BigInteger("31ac85291ff814e625e4b88c8c5047a7db2f0e45",16);                 
		w = cryptix.util.core.BI.dumpString(gprime);
		output.println("gprime = " + w);

		//calculate random k
		SecureRandom ran = new SecureRandom();
		byte[] bb = new byte[20];
		ran.nextBytes(bb);

		w = cryptix.util.core.Hex.dumpString(bb);
		output.println("20 random bytes: " + w);

		//read in a file and calculate the message digest (hash)
	  	MessageDigest md = MessageDigest.getInstance("SHA-1");
        	FileInputStream fis = new FileInputStream(args[0]);
		byte b;
        	while (fis.available() != 0) {
        		b = (byte) fis.read();
        		md.update(b);
               		};
        	fis.close();

		byte[] hash = md.digest();
		w = cryptix.util.core.Hex.dumpString(hash);
		output.println("\n");
		output.println("the SHA-1 hash of " + args[0] + " is " + w);

            // generate a DSA key pair
            KeyPairGenerator keyGen = KeyPairGenerator.getInstance("DSA");

 		keyGen.initialize(1024, ran);
            KeyPair pair = keyGen.generateKeyPair();
	
            // create a DSA Signature object
            Signature dsa = Signature.getInstance("SHA/DSA"); 

		// cast as DSAKey in order to access g, p, q directly
		DSAKey priv2 = (DSAKey) pair.getPrivate();
		DSAParams params = priv2.getParams();
		g = (BigInteger) params.getG();
		w = cryptix.util.core.BI.dumpString(g);
		output.println("generator g = " + w);
		p = (BigInteger) params.getP();
		w = cryptix.util.core.BI.dumpString(p);
		output.println("prime p = " + w);
		q = (BigInteger) params.getQ();
		w = cryptix.util.core.BI.dumpString(q);
		output.println("order q of group G(q) = " + w);
		
		// check that the parameters are valid: does p mod q = 1?
		z = p.mod(q);
		w = cryptix.util.core.BI.dumpString(z);
 		output.println("p mod q = " + w);
		
		// check that the parameters are valid: does g^q mod p = 1?
		z = g.modPow(q,p);
		w = cryptix.util.core.BI.dumpString(z);
 		output.println("g^q mod p = " + w);

		// cast as DSAPrivateKey in order to access the private key x directly
            DSAPrivateKey priv = (DSAPrivateKey) pair.getPrivate();
		x = (BigInteger) priv.getX();
		String sx = cryptix.util.core.BI.dumpString(x);
		output.println(" ");
		output.println("private key x = " + sx);

            // cast as DSAPublicKey in order to access  the public key y directly 
            DSAPublicKey pub = (DSAPublicKey) pair.getPublic();
		y = (BigInteger) pub.getY();
		String sy = cryptix.util.core.BI.dumpString(y);
		output.println(" ");
		output.println("public key y = " + sy);

		// check the validity of the public-private key relationship
		z = g.modPow(x,p);
		w = cryptix.util.core.BI.dumpString(z);
		output.println(" ");
		output.println("Note here that the value of ");
 		output.println("g^x mod p = " + w);
		output.println("which verifies the public key y.");		

         	// initialize the Signature object for signing 
         	dsa.initSign(priv);

         	//update and sign the data
		//independently check the message digest
	  	md = MessageDigest.getInstance("SHA-1");
        	fis = new FileInputStream(args[0]);
        	while (fis.available() != 0) {
        		b = (byte) fis.read();
        		md.update(b);
        		dsa.update(b);
               		};
        	fis.close();

		hash = md.digest();
		w = cryptix.util.core.Hex.dumpString(hash);
		output.println("the SHA-1 hash of " + args[0] + " is " + w);

        	// now that all the data to be signed has been read in, sign it 
		BigInteger sig1;
        	byte[] sig = dsa.sign();
		w = cryptix.util.core.Hex.dumpString(sig);
		output.println("the DSA signature (byte array) is " + w);
		sig1 = new BigInteger(sig);
		w = cryptix.util.core.BI.dumpString(sig1);
		output.println("the DSA signature (BigInteger) is " + w);

        	// extract the first part of signature 
		BigInteger Bfirst, Bsecond;
	  	byte[] bf = new byte[20];
	  	int i=0, j=0, k=0;

		// check if bytes are 0214h or 0215h and adjust accordingly
		// note that BigInteger from bytes must have positive sign
		if(sig[3]==21) j=1;
		if((j==0)&&(sig[25]==21)) k=1;
		else if((j==1)&&(sig[26]==21)) k=1;
		output.println(" j = " + j + " k = " + k);
		output.println(" sig[3] = " + sig[3] + " sig[25] = " + sig[25] + " sig[26] = " + sig[26]);
	  	for(i=4+j;i<24+j;i++) bf[i-4-j] = sig[i];
        	Bfirst = new BigInteger(bf);
		if(j==1) {byte[] bg = new byte[21];
				    bg[0] = 0;
				    for(i=1;i<21;i++) bg[i]=bf[i-1];
				    Bfirst = new BigInteger(bg);
					}

		r = Bfirst;
		w = cryptix.util.core.BI.dumpString(r);
        	output.println("The first number in signature = " + w);
        	output.println(" ");

        	// extract the second part of signature 
	  	byte[] bs = new byte[20];
	  	for(i=26+j+k;i<46+j+k;i++) bs[i-26-j-k] = sig[i];
        	Bsecond = new BigInteger(bs);
		if(k==1) {byte[] bt = new byte[21];
				    bt[0] = 0;
				    for(i=1;i<21;i++) bt[i]=bs[i-1];
				    Bsecond = new BigInteger(bt);
									}
		s = Bsecond;
       	w = cryptix.util.core.BI.dumpString(s);
        	output.println("The second number in signature = " + w);
        	output.println(" ");

		// calculate the DSA signature (and compare)
		// needed are the hash of the message, first and second
		//   parts of signature, public key y, group generator g
		BigInteger Bhash, Zero, Bfirinv, Bsecinv, Bu1, Bu2, Ba, Bb, Bt, Bv;
		Zero = new BigInteger("0");
		Bhash = new BigInteger(hash);

		// note that verification starts with the second number in the signature, does some
		// calculations, and if the result is the first number, then verification is true
		if(Bfirst.compareTo(Zero)==-1) output.println("verify = false");
		else if (Bsecond.compareTo(Zero)==-1) output.println("verify = false");
		else {
			Bsecinv = Bsecond.modInverse(q);   
			Bu1 = Bhash.multiply(Bsecinv);
			Bu1 = Bu1.mod(q);
			Bu2 = Bfirst.multiply(Bsecinv);
			Bu2 = Bu2.mod(q);
			Ba = g.modPow(Bu1,p);
			Bb = y.modPow(Bu2,p);
			Bt = Ba.multiply(Bb);
			Bt = Bt.mod(p);
			Bv = Bt.mod(q);
			if (Bv.compareTo(Bfirst)==0) output.println("verify (independent calculation) = true");
				else output.println("verify (ind calculation) = false");
        		w = cryptix.util.core.BI.dumpString(Bv);
        		output.println("verfication number is = " + w);
        		output.println(" ");
			}

		// verify the signature using the verify function
		// initialize the Signature object for verification 
            dsa.initVerify(pub);

            // update and verify the data
            fis = new FileInputStream(args[0]);
            while (fis.available() != 0) {
                b = (byte) fis.read();
                dsa.update(b);
                };
            fis.close();

            boolean verifies = dsa.verify(sig);
            output.println("signature verifies (verification function): " + verifies);
		output.println(" ");

		// NOW we are ready to calculate the private key x from the signature, 
		// substituting pprime for p and gprime for g

		// first, sign something using the private (secret) key and the faux parameters
		// (in this case we'll stick with the previously calculated hash)
		// we do the signature twice, first with true parameters p, g (which will verify)
		// and next with faux parameters pprime, gprime (which will not)

		BigInteger One, Two, kinv;		
		One = new BigInteger("1");
		Two = new BigInteger("2");

		ran = new SecureRandom();
		ran.nextBytes(bb); //leave outside loop so same bytes used in each case
		w = cryptix.util.core.Hex.dumpString(bb);
		output.println("20 random bytes: " + w);
	
		kk = new BigInteger(bb);
		kk = kk.mod(q);
		w = cryptix.util.core.BI.dumpString(kk);
		output.println("random bytes mod q: " + w);

		for(i=0;i<2;i++) {

		if(i==1) p = pprime;
		if(i==1) g = gprime;
		
		r = g.modPow(kk,p);
		r = r.mod(q);

		Bfirst=r;
		w = cryptix.util.core.BI.dumpString(r);
        	output.println("The first number in (possibly faux) signature = " + w);
        	output.println(" ");

		kinv = kk.modInverse(q);
		s = x.multiply(r);
		s = s.add(Bhash);
		s = s.multiply(kinv);
		s = s.mod(q);

		Bsecond=s;
       	w = cryptix.util.core.BI.dumpString(s);
        	output.println("The second number in (possibly faux) signature = " + w);
        	output.println(" ");
		
		// verify that the signature works
		if(Bfirst.compareTo(Zero)==-1) output.println("verify = false");
		else if (Bsecond.compareTo(Zero)==-1) output.println("verify = false");
		else {
			Bsecinv = Bsecond.modInverse(q);   
			Bu1 = Bhash.multiply(Bsecinv);
			Bu1 = Bu1.mod(q);
			Bu2 = Bfirst.multiply(Bsecinv);
			Bu2 = Bu2.mod(q);
			Ba = g.modPow(Bu1,p);
			Bb = y.modPow(Bu2,p);
			Bt = Ba.multiply(Bb);
			Bt = Bt.mod(p);
			Bv = Bt.mod(q);
			if (Bv.compareTo(Bfirst)==0) output.println("verify (independent calculation) = true");
				else output.println("verify (ind calculation) = false");
        		w = cryptix.util.core.BI.dumpString(Bv);
        		output.println("verfication number is = " + w);
        		output.println(" ");
			}

					}

		// now calculate the private key x from the faux signature (r,s)
		// first verify the value of pprime
		int sk=151;
		Integer Ij;
		BigInteger Btk = new BigInteger("167");
		int[] wk = new int[152];
		BigInteger f, v, yk, Hack, Bj;
		Hack = Two.pow(sk);
		Hack = Hack.multiply(Btk);
		Hack = Hack.add(One);
        	w = cryptix.util.core.BI.dumpString(Hack);
        	output.println("pprime (calculated) is = " + w);

		// now set up routine to get the bits of k by looking at quadratic residues
		p = pprime;
		g = gprime;
		BigInteger val, ival, TwoPower, PminusOne;
		TwoPower = One;
        	v = p.subtract(One);
		Bv = Zero;
		PminusOne = p.subtract(One);
			
		for(i=1;i<=151;i++) {
			//output.println("i = " + i);
			v = v.divide(Two); 
			//w = cryptix.util.core.BI.dumpString(v);
        		//output.println("v is = " + w);			
			yk = r.modPow(v,p);
        		//w = cryptix.util.core.BI.dumpString(yk);
        		//output.println("yk is = " + w);
			if(yk.compareTo(One)==0) wk[i]= 0;
				else wk[i]=1;
			//output.println("wk["+i+"] = " + wk[i]);
			Ij = new Integer(wk[i]);
			w = Ij.toString();
			Bj = new BigInteger(w);
			Bj = Bj.multiply(TwoPower);
			Bv = Bv.add(Bj);
			Ba = PminusOne.subtract(Bv);
        		//w = cryptix.util.core.BI.dumpString(Ba);
        		//output.println(" q - w bits (so far) is = " + w);
			f = g.modPow(Ba,p);
        		//w = cryptix.util.core.BI.dumpString(f);
        		//output.println("f is = " + w);
			r=Bfirst.multiply(f);
			r=r.mod(p); 
			TwoPower = TwoPower.multiply(Two);
			//w = cryptix.util.core.BI.dumpString(r);
        		//output.println("r is = " + w);
						}	
		
	      for(i=151;i>=1;i--) output.print(wk[i]);
		output.println(" ");

		// calculate the value of w mod 2^s
		TwoPower = Two;
		if(wk[1]==1) val = One;
			else   val = Zero;
		for (i=2;i<=151;i++) {
			if(wk[i]==1) ival = One;
				else ival = Zero;
			ival = ival.multiply(TwoPower);
			TwoPower = TwoPower.multiply(Two);
			val = val.add(ival);
					}
        	w = cryptix.util.core.BI.dumpString(val);
        	output.println("***** w mod 2^s is = " + w);

		r = Bfirst; //restore value of r, altered by loop

		// now calculate value of w mod t = j
		Hack = Two.pow(sk);
		Bu1 = r.modPow(Hack,p);
		Bu2 = g.modPow(Hack,p);
		Bv = Bu2;
        	w = cryptix.util.core.BI.dumpString(Bu1);
        	output.println("r^((p-1)/t) is = " + w);
        	w = cryptix.util.core.BI.dumpString(Bu2);
        	output.println("g^((p-1)/t) is = " + w);

		j = 1;
		if(Bu1.compareTo(One)==0) j = 0;
		else if(Bu1.compareTo(Bu2)==0) j = 1;
			else {
			while(Bu1.compareTo(Bu2)!=0) {
			Bu2 = Bu2.multiply(Bv);
			Bu2 = Bu2.mod(p);
			j = j+1; 
			//output.println("j = "+j);
	        	//w = cryptix.util.core.BI.dumpString(Bu2);
      	  	//output.println("g^((p-1)/t)*j) is = " + w);

			if(j>166) break; }}

		output.println("***** w mod t = " + j);
        	w = cryptix.util.core.BI.dumpString(Bu1);
        	output.println("r^((p-1)/t) is = " + w);
        	w = cryptix.util.core.BI.dumpString(Bu2);
        	output.println("g^((p-1)/t)*j) is = " + w);

		// calculate w from w mod t and w mod 2^s
		Ij = new Integer(j);
		w = Ij.toString();
		Bj = new BigInteger(w);
		w = cryptix.util.core.BI.dumpString(Bj);
		output.println("j as BigInteger " + w);
		Hack = Two.pow(sk);
		Ba = Hack.modInverse(Btk);
		Bb = Bj.subtract(val);
		Bb = Bb.multiply(Ba);
		Bb = Bb.mod(Btk);
		Bv = Bb.multiply(Hack);
		Bv = Bv.add(val);
		Bv = Bv.mod(q);
   		w = cryptix.util.core.BI.dumpString(Bv);
		output.println("value of w from CRT is: " + w);


		// now determine the set K (w determines 4 possible values for k)
		Bb = p.subtract(One);
		Bu1 = r.modInverse(q);
		Integer Ii;
		
		for(i=0;i<4;i++) {

		Ii = new Integer(i);
		w = Ii.toString();
		Ba = new BigInteger(w);

		kk = Ba.multiply(Bb);
		kk = Bv.add(kk);

     		w = cryptix.util.core.BI.dumpString(kk);
        	output.println("possible value of k is = " + w);

		Ba = kk.multiply(s);
		Ba = Ba.subtract(Bhash);
		Ba = Ba.multiply(Bu1);
		Ba = Ba.mod(q);

     		w = cryptix.util.core.BI.dumpString(Ba);
        	output.println("possible private key (calculated) x is = " + w);

		Bu2 = gstore.modPow(Ba,pstore);
     		w = cryptix.util.core.BI.dumpString(Bu2);
        	output.println("calculated public key y from possible private key is = " + w);

		if(Bu2.compareTo(y)==0) {
		output.println("Private key found! This is it!**********************");
		output.println(" ");
			break;  } 
					}		

        	w = cryptix.util.core.BI.dumpString(x);
        	output.println(" (real) private key x actually is = " + w);

		outFile.close();
		System.out.println("File written");

        } catch (Exception e) {
            System.err.println("Caught exception " + e.toString());
        }

    }

}

