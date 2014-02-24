/*
       Licensed to the Apache Software Foundation (ASF) under one
       or more contributor license agreements.  See the NOTICE file
       distributed with this work for additional information
       regarding copyright ownership.  The ASF licenses this file
       to you under the Apache License, Version 2.0 (the
       "License"); you may not use this file except in compliance
       with the License.  You may obtain a copy of the License at

         http://www.apache.org/licenses/LICENSE-2.0

       Unless required by applicable law or agreed to in writing,
       software distributed under the License is distributed on an
       "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
       KIND, either express or implied.  See the License for the
       specific language governing permissions and limitations
       under the License.
 */

package com.phonegap.helloworld;

import org.apache.cordova.Config;
import org.apache.cordova.CordovaActivity;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.webkit.WebView;
import android.widget.LinearLayout;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdSize;
import com.google.android.gms.ads.AdView;

public class HelloWorld extends CordovaActivity
{
	private AdView adView;
	private Handler mHandler = new Handler();
	
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
    	
    	if(Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
		    WebView.setWebContentsDebuggingEnabled(true);
		}
    	
//    	WebView mWebView = (WebView) findViewById(R.id.activity_main_webview);
    	
    	// Enable Javascript
//		WebSettings webSettings = mWebView.getSettings();
//		webSettings.setJavaScriptEnabled(true);
    	
        super.onCreate(savedInstanceState);
        super.init();
        
        mHandler.postDelayed(new Runnable() {
            public void run() {
            	loadAds();
            }
        }, 5000);

        super.loadUrl(Config.getStartUrl());
    }
    
    private void loadAds() {
    	// Create the adView.
        adView = new AdView(this);
        adView.setAdUnitId("ca-app-pub-2521908531037969/8584172820");
        adView.setAdSize(AdSize.BANNER);
        
    	LinearLayout layout = super.root;
        // Add the adView to it.
        layout.addView(adView);

        // Initiate a generic request.
        AdRequest adRequest = new AdRequest.Builder()
        	.addTestDevice("A03947401522BCB9578353AFD9D1D721") // Nexus 7
        	.addTestDevice("4FCC0B76C75269F7074D3303208BB95A") // Sensation
        	.build();

        // Load the adView with the ad request.
        adView.loadAd(adRequest);
    }

    @Override
    public void onPause() {
//      adView.pause();
      super.onPause();
    }

    @Override
    public void onResume() {
      super.onResume();
//      adView.resume();
    }

    @Override
    public void onDestroy() {
//      adView.destroy();
      super.onDestroy();
    }

}

